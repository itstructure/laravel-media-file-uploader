<?php

namespace Itstructure\MFU\Services;

use Itstructure\MFU\Processors\SaveProcessor;
use Itstructure\MFU\Models\Mediafile;
use Itstructure\MFU\Helpers\HtmlHelper;

class Previewer
{
    const LOCATION_FILE_ITEM = 'fileitem';
    const LOCATION_FILE_INFO = 'fileinfo';
    const LOCATION_EXISTING = 'existing';

    /**
     * @var array
     */
    private $config;

    /**
     * @param array $config
     * @return Previewer
     */
    public static function getInstance(array $config = []): self
    {
        return new static($config);
    }

    /**
     * Previewer constructor.
     * @param array $config
     */
    private function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * @param Mediafile $mediafile
     * @param string $location
     * @param array $htmlAttributes
     * @return string
     */
    public function getPreviewHtml(Mediafile $mediafile, string $location, array $htmlAttributes = []): string
    {
        if ($mediafile->isImage()) {
            return $this->getImagePreview($mediafile, $location, $htmlAttributes);

        } else if ($mediafile->isAudio()) {
            return $this->getAudioPreview($mediafile, $location, $htmlAttributes);

        } else if ($mediafile->isVideo()) {
            return $this->getVideoPreview($mediafile, $location, $htmlAttributes);

        } else if ($mediafile->isApp()) {
            return $this->getStubAppPreview($mediafile, $location, $htmlAttributes);

        } else if ($mediafile->isText()) {
            return $this->getStubTextPreview($location, $htmlAttributes);

        } else {
            return $this->getStubOtherPreview($location, $htmlAttributes);
        }
    }

    /**
     * @param Mediafile $mediafile
     * @param string $location
     * @param array $htmlAttributes
     * @param string $alias
     * @return string
     */
    public function getImagePreview(Mediafile $mediafile, string $location, array $htmlAttributes = [], string $alias = SaveProcessor::THUMB_ALIAS_DEFAULT): string
    {
        return view('uploader::preview.image', [
            'src' => $mediafile->getThumbUrl($alias),
            'alt' => $mediafile->getAlt(),
            'htmlAttributes' => $this->getHtmlAttributes(SaveProcessor::FILE_TYPE_IMAGE, $location, $htmlAttributes)
        ]);
    }

    /**
     * @param Mediafile $mediafile
     * @param string $location
     * @param array $htmlAttributes
     * @return string
     */
    public function getAudioPreview(Mediafile $mediafile, string $location, array $htmlAttributes = []): string
    {
        return view('uploader::preview.audio', [
            'src' => $mediafile->getViewUrl(),
            'type' => $mediafile->getMimeType(),
            'htmlAttributes' => $this->getHtmlAttributes(SaveProcessor::FILE_TYPE_AUDIO, $location, $htmlAttributes)
        ]);
    }

    /**
     * @param Mediafile $mediafile
     * @param string $location
     * @param array $htmlAttributes
     * @return string
     */
    public function getVideoPreview(Mediafile $mediafile, string $location, array $htmlAttributes = []): string
    {
        return view('uploader::preview.video', [
            'src' => $mediafile->getViewUrl(),
            'type' => $mediafile->getMimeType(),
            'htmlAttributes' => $this->getHtmlAttributes(SaveProcessor::FILE_TYPE_VIDEO, $location, $htmlAttributes)
        ]);
    }

    /**
     * @param Mediafile $mediafile
     * @param string $location
     * @param array $htmlAttributes
     * @return string
     */
    public function getStubAppPreview(Mediafile $mediafile, string $location, array $htmlAttributes = []): string
    {
        if ($mediafile->isWord()) {
            return view('uploader::preview.stub.word', [
                'htmlAttributes' => $this->getHtmlAttributes(SaveProcessor::FILE_TYPE_APP_WORD, $location, $htmlAttributes)
            ]);
        } else if ($mediafile->isExcel()) {
            return view('uploader::preview.stub.excel', [
                'htmlAttributes' => $this->getHtmlAttributes(SaveProcessor::FILE_TYPE_APP_EXCEL, $location, $htmlAttributes)
            ]);
        } else if ($mediafile->isPdf()) {
            return view('uploader::preview.stub.pdf', [
                'htmlAttributes' => $this->getHtmlAttributes(SaveProcessor::FILE_TYPE_APP_PDF, $location, $htmlAttributes)
            ]);
        } else {
            return view('uploader::preview.stub.app', [
                'htmlAttributes' => $this->getHtmlAttributes(SaveProcessor::FILE_TYPE_APP, $location, $htmlAttributes)
            ]);
        }
    }

    /**
     * @param string $location
     * @param array $htmlAttributes
     * @return string
     */
    public function getStubTextPreview(string $location, array $htmlAttributes = []): string
    {
        return view('uploader::preview.stub.text', [
            'htmlAttributes' => $this->getHtmlAttributes(SaveProcessor::FILE_TYPE_TEXT, $location, $htmlAttributes)
        ]);
    }

    /**
     * @param string $location
     * @param array $htmlAttributes
     * @return string
     */
    public function getStubOtherPreview(string $location, array $htmlAttributes = []): string
    {
        return view('uploader::preview.stub.other', [
            'htmlAttributes' => $this->getHtmlAttributes(SaveProcessor::FILE_TYPE_OTHER, $location, $htmlAttributes)
        ]);
    }

    /**
     * @param string $fileType
     * @param string $location
     * @param array $additional
     * @return string
     */
    private function getHtmlAttributes(string $fileType,  string $location, array $additional = []): string
    {
        $htmlAttributes = isset($this->config['htmlAttributes'])
        && isset($this->config['htmlAttributes'][$fileType])
        && isset($this->config['htmlAttributes'][$fileType][$location])
            ? $this->config['htmlAttributes'][$fileType][$location]
            : [];
        $htmlAttributes = array_merge($htmlAttributes, $additional);
        return HtmlHelper::buildHtmlAttributes($htmlAttributes);
    }
}
