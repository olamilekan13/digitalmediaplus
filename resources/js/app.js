import './bootstrap';

import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import collapse from '@alpinejs/collapse';
import tinymce from 'tinymce';

// Import TinyMCE themes and plugins
import 'tinymce/themes/silver';
import 'tinymce/icons/default';
import 'tinymce/models/dom';

// Import TinyMCE plugins
import 'tinymce/plugins/lists';
import 'tinymce/plugins/link';
import 'tinymce/plugins/image';
import 'tinymce/plugins/table';
import 'tinymce/plugins/code';
import 'tinymce/plugins/wordcount';

// Register Alpine plugins
Alpine.plugin(intersect);
Alpine.plugin(collapse);

window.Alpine = Alpine;
window.tinymce = tinymce;

Alpine.start();
