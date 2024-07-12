<?php

namespace Itstructure\MFU\Processors;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\{
    Storage, Validator
};
use Itstructure\MFU\Classes\ThumbConfig;
use Itstructure\MFU\Helpers\{
    ImageHelper, ThumbHelper
};

/**
 * Class SaveProcessor
 * @package Itstructure\MFU\Processors
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
abstract class SaveProcessor extends BaseProcessor
{
    const FILE_TYPE_IMAGE = 'image';
    const FILE_TYPE_AUDIO = 'audio';
    const FILE_TYPE_VIDEO = 'video';
    const FILE_TYPE_APP = 'application';
    const FILE_TYPE_APP_WORD = 'word';
    const FILE_TYPE_APP_EXCEL = 'excel';
    const FILE_TYPE_APP_VISIO = 'visio';
    const FILE_TYPE_APP_PPT = 'powerpoint';
    const FILE_TYPE_APP_PDF = 'pdf';
    const FILE_TYPE_TEXT = 'text';
    const FILE_TYPE_OTHER = 'other';
    const FILE_TYPE_THUMB = 'thumbnail';

    const THUMB_ALIAS_DEFAULT = 'default';
    const THUMB_ALIAS_ORIGINAL = 'original';
    const THUMB_ALIAS_SMALL = 'small';
    const THUMB_ALIAS_MEDIUM = 'medium';
    const THUMB_ALIAS_LARGE = 'large';

    const DIR_LENGTH_FIRST = 2;
    const DIR_LENGTH_SECOND = 4;

    const VISIBILITY_PUBLIC = 'public';
    const VISIBILITY_PRIVARE = 'private';

    const DEFAULT_BASE_UPLOAD_DIRECTORY = 'default';

    /************************* CONFIG ATTRIBUTES *************************/
    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var bool
     */
    protected $renameFiles;

    /**
     * @var bool
     */
    protected $checkExtensionByFileType;

    /**
     * @var int
     */
    protected $maxFileSize;

    /**
     * @var array
     */
    protected $fileExtensions;

    /**
     * @var array
     */
    protected $thumbSizes;

    /**
     * @var string
     */
    protected $thumbFilenameTemplate;

    /**
     * @var array
     */
    protected $baseUploadDirectories;

    /**
     * @var array
     */
    protected $metaDataValidationRules = [];

    /**
     * @var array
     */
    protected $metaDataValidationMessageTranslations = [];

    /**
     * @var array
     */
    protected $metaDataValidationAttributeTranslations = [];

    /**
     * @var array
     */
    protected $fileValidationMessageTranslations = [];

    /**
     * @var array
     */
    protected $fileValidationAttributeTranslations = [];

    /**
     * @var string
     */
    protected $visibility;


    /************************* PROCESS ATTRIBUTES *************************/
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var UploadedFile
     */
    protected $file;

    /**
     * @var string
     */
    protected $outFileName;

    /**
     * @var string
     */
    protected $path;


    /************************* ABSTRACT METHODS ***************************/
    abstract protected function isFileRequired(): bool;


    /************************* CONFIG SETTERS *****************************/
    /**
     * @param string $baseUrl
     * @return $this
     */
    public function setBaseUrl(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    /**
     * @param bool $renameFiles
     * @return $this
     */
    public function setRenameFiles(bool $renameFiles)
    {
        $this->renameFiles = $renameFiles;
        return $this;
    }

    /**
     * @param bool $checkExtensionByFileType
     * @return $this
     */
    public function setCheckExtensionByFileType(bool $checkExtensionByFileType)
    {
        $this->checkExtensionByFileType = $checkExtensionByFileType;
        return $this;
    }

    /**
     * @param int $maxFileSize
     * @return $this
     */
    public function setMaxFileSize(int $maxFileSize)
    {
        $this->maxFileSize = $maxFileSize;
        return $this;
    }

    /**
     * @param array $fileExtensions
     * @return $this
     */
    public function setFileExtensions(array $fileExtensions)
    {
        $this->fileExtensions = $fileExtensions;
        return $this;
    }

    /**
     * @param array $thumbSizes
     * @return $this
     */
    public function setThumbSizes(array $thumbSizes)
    {
        $this->thumbSizes = $thumbSizes;
        return $this;
    }

    /**
     * @param string $thumbFilenameTemplate
     * @return $this
     */
    public function setThumbFilenameTemplate(string $thumbFilenameTemplate)
    {
        $this->thumbFilenameTemplate = $thumbFilenameTemplate;
        return $this;
    }

    /**
     * @param array $baseUploadDirectories
     * @return $this
     */
    public function setBaseUploadDirectories(array $baseUploadDirectories)
    {
        $this->baseUploadDirectories = $baseUploadDirectories;
        return $this;
    }

    /**
     * @param array $metaDataValidationRules
     * @return $this
     */
    public function setMetaDataValidationRules(array $metaDataValidationRules)
    {
        $this->metaDataValidationRules = $metaDataValidationRules;
        return $this;
    }

    /**
     * @param array $metaDataValidationMessageTranslations
     * @return $this
     */
    public function setMetaDataValidationMessageTranslations(array $metaDataValidationMessageTranslations)
    {
        $this->metaDataValidationMessageTranslations = $metaDataValidationMessageTranslations;
        return $this;
    }

    /**
     * @param array $metaDataValidationAttributeTranslations
     * @return $this
     */
    public function setMetaDataValidationAttributeTranslations(array $metaDataValidationAttributeTranslations)
    {
        $this->metaDataValidationAttributeTranslations = $metaDataValidationAttributeTranslations;
        return $this;
    }

    /**
     * @param array $fileValidationMessageTranslations
     * @return $this
     */
    public function setFileValidationMessageTranslations(array $fileValidationMessageTranslations)
    {
        $this->fileValidationMessageTranslations = $fileValidationMessageTranslations;
        return $this;
    }

    /**
     * @param array $fileValidationAttributeTranslations
     * @return $this
     */
    public function setFileValidationAttributeTranslations(array $fileValidationAttributeTranslations)
    {
        $this->fileValidationAttributeTranslations = $fileValidationAttributeTranslations;
        return $this;
    }

    /**
     * @param string $visibility
     * @return $this
     */
    public function setVisibility(string $visibility)
    {
        $this->visibility = $visibility;
        return $this;
    }


    /********************** PROCESS PUBLIC METHODS ***********************/
    /**
     * @throws Exception
     * @return bool
     */
    public function run(): bool
    {
        if (!$this->validate()) {
            return false;
        }
        return parent::run();
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param UploadedFile|null $file
     * @return $this
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return UploadedFile|null
     */
    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    /**
     * @throws Exception
     * @return bool
     */
    public function createThumbs(): bool
    {
        $thumbs = [];

        ImageHelper::$driver = [ImageHelper::DRIVER_GD2, ImageHelper::DRIVER_GMAGICK, ImageHelper::DRIVER_IMAGICK];

        foreach ($this->thumbSizes as $alias => $preset) {
            $thumbs[$alias] = $this->createThumb(ThumbHelper::configureThumb($alias, $preset));
        }

        // Create default thumb.
        if (!array_key_exists(self::THUMB_ALIAS_DEFAULT, $this->thumbSizes)) {
            $defaultThumbConfig = ThumbHelper::configureThumb(self::THUMB_ALIAS_DEFAULT, ThumbHelper::getDefaultSizes());
            $thumbs[self::THUMB_ALIAS_DEFAULT] = $this->createThumb($defaultThumbConfig);
        }

        $this->mediafileModel->thumbs = $thumbs;

        return $this->mediafileModel->save();
    }

    /**
     * @param string $mimeType
     * @return bool
     */
    public static function isImage(string $mimeType): bool
    {
        return strpos($mimeType, self::FILE_TYPE_IMAGE) !== false;
    }

    /**
     * @param string $mimeType
     * @return bool
     */
    public static function isAudio(string $mimeType): bool
    {
        return strpos($mimeType, self::FILE_TYPE_AUDIO) !== false;
    }

    /**
     * @param string $mimeType
     * @return bool
     */
    public static function isVideo(string $mimeType): bool
    {
        return strpos($mimeType, self::FILE_TYPE_VIDEO) !== false;
    }

    /**
     * @param string $mimeType
     * @return bool
     */
    public static function isText(string $mimeType): bool
    {
        return strpos($mimeType, self::FILE_TYPE_TEXT) !== false;
    }

    /**
     * @param string $mimeType
     * @return bool
     */
    public static function isApp(string $mimeType): bool
    {
        return strpos($mimeType, self::FILE_TYPE_APP) !== false;
    }

    /**
     * @param string $mimeType
     * @return bool
     */
    public static function isWord(string $mimeType): bool
    {
        return strpos($mimeType, self::FILE_TYPE_APP_WORD) !== false;
    }

    /**
     * @param string $mimeType
     * @return bool
     */
    public static function isExcel(string $mimeType): bool
    {
        return strpos($mimeType, self::FILE_TYPE_APP_EXCEL) !== false
        || strpos($mimeType, 'spreadsheet') !== false;
    }

    /**
     * @param string $mimeType
     * @return bool
     */
    public static function isVisio(string $mimeType): bool
    {
        return strpos($mimeType, self::FILE_TYPE_APP_VISIO) !== false;
    }

    /**
     * @param string $mimeType
     * @return bool
     */
    public static function isPowerPoint(string $mimeType): bool
    {
        return strpos($mimeType, self::FILE_TYPE_APP_PPT) !== false
        || strpos($mimeType, 'presentation') !== false;
    }

    /**
     * @param string $mimeType
     * @return bool
     */
    public static function isPdf(string $mimeType): bool
    {
        return strpos($mimeType, self::FILE_TYPE_APP_PDF) !== false;
    }


    /********************** PROCESS INTERNAL METHODS *********************/
    /**
     * @return bool
     */
    protected function validate(): bool
    {
        $resultMetaData = $this->validateMetaData();
        $resultFile = $this->validateFile();
        return $resultMetaData && $resultFile;
    }

    protected function validateMetaData(): bool
    {
        $metaDataValidator = Validator::make(
            $this->data,
            $this->metaDataValidationRules,
            $this->prepareValidationTranslations($this->metaDataValidationMessageTranslations),
            $this->prepareValidationTranslations($this->metaDataValidationAttributeTranslations)
        );
        if ($this->checkExtensionByFileType) {
            $metaDataValidator->addRules(['needed_file_type' => 'required']);
        }
        if ($metaDataValidator->fails()) {
            $this->errors = !is_null($this->errors)
                ? $this->errors->merge($metaDataValidator->getMessageBag())
                : $metaDataValidator->getMessageBag();
            return false;
        }
        return true;
    }

    protected function validateFile(): bool
    {
        $fileValidator = Validator::make(['file' => $this->file], [
                'file' => [
                    $this->isFileRequired() ? 'required' : 'nullable',
                    'max:' . $this->maxFileSize
                ]
            ],
            $this->prepareValidationTranslations($this->fileValidationMessageTranslations),
            $this->prepareValidationTranslations($this->fileValidationAttributeTranslations)
        );
        if ($this->checkExtensionByFileType && !empty($this->data['needed_file_type'])
            && !empty($this->fileExtensions[$this->data['needed_file_type']])) {
            $fileValidator->addRules([
                'file' => [
                    'mimes:' . implode(',', $this->fileExtensions[$this->data['needed_file_type']]),
                ]
            ]);
        }
        if ($fileValidator->fails()) {
            $this->errors = !is_null($this->errors)
                ? $this->errors->merge($fileValidator->getMessageBag())
                : $fileValidator->getMessageBag();
            return false;
        }
        return true;
    }

    protected function prepareValidationTranslations(array $translations): array
    {
        foreach ($translations as $key => $value) {
            $translations[$key] = __($value);
        }
        return $translations;
    }


    /**
     * @return bool
     */
    protected function sendFile(): bool
    {
        Storage::disk($this->currentDisk)->putFileAs($this->processDirectory, $this->file, $this->outFileName, [
            'visibility' => $this->data['visibility'] ?? $this->visibility
        ]);

        return Storage::disk($this->currentDisk)->fileExists($this->processDirectory . '/' . $this->outFileName);
    }

    /**
     * @param string $mimeType
     * @throws Exception
     * @return string
     */
    protected function getBaseUploadDirectory(string $mimeType): string
    {
        if (!is_array($this->baseUploadDirectories) || empty($this->baseUploadDirectories)) {
            throw new Exception('The baseUploadDirectories attribute is not defined correctly.');
        }

        if (self::isImage($mimeType)) {
            return $this->baseUploadDirectories[self::FILE_TYPE_IMAGE] ?? self::DEFAULT_BASE_UPLOAD_DIRECTORY;

        } elseif (self::isAudio($mimeType)) {
            return $this->baseUploadDirectories[self::FILE_TYPE_AUDIO] ?? self::DEFAULT_BASE_UPLOAD_DIRECTORY;

        } elseif (self::isVideo($mimeType)) {
            return $this->baseUploadDirectories[self::FILE_TYPE_VIDEO] ?? self::DEFAULT_BASE_UPLOAD_DIRECTORY;

        } elseif (self::isApp($mimeType)) {
            if (self::isWord($mimeType)) {
                return $this->baseUploadDirectories[self::FILE_TYPE_APP_WORD] ?? self::DEFAULT_BASE_UPLOAD_DIRECTORY;

            } elseif (self::isExcel($mimeType)) {
                return $this->baseUploadDirectories[self::FILE_TYPE_APP_EXCEL] ?? self::DEFAULT_BASE_UPLOAD_DIRECTORY;

            } elseif (self::isVisio($mimeType)) {
                return $this->baseUploadDirectories[self::FILE_TYPE_APP_VISIO] ?? self::DEFAULT_BASE_UPLOAD_DIRECTORY;

            } elseif (self::isPowerPoint($mimeType)) {
                return $this->baseUploadDirectories[self::FILE_TYPE_APP_PPT] ?? self::DEFAULT_BASE_UPLOAD_DIRECTORY;

            } elseif (self::isPdf($mimeType)) {
                return $this->baseUploadDirectories[self::FILE_TYPE_APP_PDF] ?? self::DEFAULT_BASE_UPLOAD_DIRECTORY;

            } else {
                return $this->baseUploadDirectories[self::FILE_TYPE_APP] ?? self::DEFAULT_BASE_UPLOAD_DIRECTORY;
            }

        } elseif (self::isText($mimeType)) {
            return $this->baseUploadDirectories[self::FILE_TYPE_TEXT] ?? self::DEFAULT_BASE_UPLOAD_DIRECTORY;

        } else {
            return $this->baseUploadDirectories[self::FILE_TYPE_OTHER] ?? self::DEFAULT_BASE_UPLOAD_DIRECTORY;
        }
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function getNewProcessDirectory(): string
    {
        $processDirectory = rtrim(rtrim($this->getBaseUploadDirectory($this->file->getMimeType()), '/'), '\\');

        if (!empty($this->data['sub_dir'])) {
            $processDirectory .= '/' . trim(trim($this->data['sub_dir'], '/'), '\\');
        }

        return $processDirectory .
            '/' . substr(md5(time()), 0, self::DIR_LENGTH_FIRST) .
            '/' . substr(md5(microtime() . $this->file->getBasename()), 0, self::DIR_LENGTH_SECOND);
    }

    /**
     * @return string
     */
    protected function getNewOutFileName(): string
    {
        return $this->renameFiles ?
            Str::uuid()->toString() . '.' . $this->file->extension() :
            Str::slug($this->file->getClientOriginalName(), '.');
    }

    /**
     * @param ThumbConfig $thumbConfig
     * @return string
     */
    protected function createThumb(ThumbConfig $thumbConfig)
    {
        $originalPathInfo = pathinfo($this->mediafileModel->getPath());

        $thumbPath = $originalPathInfo['dirname'] .
            '/' .
            $this->getThumbFilename($originalPathInfo['filename'],
                $originalPathInfo['extension'],
                $thumbConfig->getAlias(),
                $thumbConfig->getWidth(),
                $thumbConfig->getHeight()
            );

        $thumbContent = ImageHelper::thumbnail(
            ImageHelper::getImagine()->load(Storage::disk($this->currentDisk)->get($this->mediafileModel->getPath())),
            $thumbConfig->getWidth(),
            $thumbConfig->getHeight(),
            $thumbConfig->getMode()
        )->get($originalPathInfo['extension']);

        Storage::disk($this->currentDisk)->put($thumbPath, $thumbContent);

        return $thumbPath;
    }

    /**
     * @param $original
     * @param $extension
     * @param $alias
     * @param $width
     * @param $height
     * @return string
     */
    protected function getThumbFilename($original, $extension, $alias, $width, $height)
    {
        return strtr($this->thumbFilenameTemplate, [
            '{original}' => $original,
            '{extension}' => $extension,
            '{alias}' => $alias,
            '{width}' => $width,
            '{height}' => $height,
        ]);
    }

    protected function setMediafileBaseData(): void
    {
        $this->mediafileModel->path = $this->path;
        $this->mediafileModel->file_name = $this->outFileName;
        $this->mediafileModel->size = $this->file->getSize();
        $this->mediafileModel->mime_type = $this->file->getMimeType();
        $this->mediafileModel->disk = $this->currentDisk;
    }

    protected function setMediafileMetaData(): void
    {
        $this->mediafileModel->alt = $this->data['alt'] ?? '';
        $this->mediafileModel->title = $this->data['title'] ?? '';
        $this->mediafileModel->description = $this->data['description'] ?? '';
    }
}
