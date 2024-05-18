<?php

namespace Mini\Cms\Modules\FileSystem;

enum FileTypeEnum: string
{
    // Images
    case IMAGE_PNG = 'image/png';

    case IMAGE_GIF = 'image/gif';

    case IMAGE_JPEG = 'image/jpeg';

    case IMAGE_SVG = 'image/svg+xml';

    case IMAGE_JPG = 'image/jpg';

    // Documents
    case FILE_PDF = 'application/pdf';
    case FILE_DOC = 'application/msword';
    case FILE_DOCX = 'application/vnd.openxmlformats-document';

    case FILE_ODT = 'application/vnd.oasis.opendocument.text';

    case FILE_ODG = 'application/vnd.oasis.opendocument.data';

    case FILE_TEXT = 'text/plain';

    case FILE_JSON = 'application/json';

    case FILE_XML = 'application/xml';

    case FILE_EXCEL = 'application/vnd.ms-excel';

    case FILE_HTML = 'text/html';

    // Video files
    case VIDEO_MP4 = 'video/mp4';

    case VIDEO_MKV = 'video/x-msvideo';

    case VIDEO_WEBM = 'video/webm';

    case VIDEO_OGG = 'video/ogg';

    case VIDEO_WAV = 'video/wav';

    case VIDEO_MPG = 'video/mpg';

    // Audio file
    case AUDIO_MP3 = 'audio/mp3';
    case AUDIO_WAV = 'audio/wav';

    case AUDIO_OGG = 'audio/ogg';

    case AUDIO_MPEG = 'audio/mpeg';

    case AUDIO_ODT = 'audio/odt';

}