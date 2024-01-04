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

    private function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function getPreviewHtml(Mediafile $mediafile, string $location, array $htmlAttributes = []): string
    {
        if ($mediafile->isImage()) {
            return $this->getImagePreview($mediafile, $location, $htmlAttributes);

        } else if ($mediafile->isAudio()) {
            return $this->getAudioPreview($mediafile, $location, $htmlAttributes);

        } else if ($mediafile->isVideo()) {
            return $this->getVideoPreview($mediafile, $location, $htmlAttributes);

        } else if ($mediafile->isApp()) {
            return $this->getAppPreview($mediafile, $location, $htmlAttributes);

        }
    }

    public function getImagePreview(Mediafile $mediafile,  string $location, array $htmlAttributes = [], string $alias = SaveProcessor::THUMB_ALIAS_DEFAULT): string
    {
        return view('uploader::preview.image', [
            'src' => $mediafile->getThumbUrl($alias),
            'alt' => $mediafile->getAlt(),
            'htmlAttributes' => $this->getHtmlAttributes(SaveProcessor::FILE_TYPE_IMAGE, $location, $htmlAttributes)
        ]);
    }

    public function getAudioPreview(Mediafile $mediafile,  string $location, array $htmlAttributes = []): string
    {
        return view('uploader::preview.audio', [
            'src' => $mediafile->getViewUrl(),
            'type' => $mediafile->getMimeType(),
            'htmlAttributes' => $this->getHtmlAttributes(SaveProcessor::FILE_TYPE_AUDIO, $location, $htmlAttributes)
        ]);
    }

    public function getVideoPreview(Mediafile $mediafile,  string $location, array $htmlAttributes = []): string
    {
        return view('uploader::preview.video', [
            'src' => $mediafile->getViewUrl(),
            'type' => $mediafile->getMimeType(),
            'htmlAttributes' => $this->getHtmlAttributes(SaveProcessor::FILE_TYPE_VIDEO, $location, $htmlAttributes)
        ]);
    }

    public function getAppPreview(Mediafile $mediafile,  string $location, array $htmlAttributes = []): string
    {

    }

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
