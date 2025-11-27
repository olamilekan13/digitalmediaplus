import './bootstrap';

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

// Register Alpine plugins once Livewire's bundled Alpine boots
document.addEventListener('alpine:init', () => {
    window.Alpine.plugin(intersect);
    window.Alpine.plugin(collapse);
});

window.tinymce = tinymce;
