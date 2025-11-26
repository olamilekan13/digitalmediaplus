# CKEditor Installation Instructions for All Forms

All forms now use **CKEditor 5** instead of TinyMCE.

## ✅ Already Updated:
1. **service-form.blade.php** - ✅ Done
2. **about-section-form.blade.php** - ✅ Done (has 2 editors: description & story_text)

## 📝 Need to Update:

For each of the following forms, **replace the entire `@push('scripts')` section** with the code below:

### Forms to Update:
- feature-highlight-form.blade.php
- faq-form.blade.php
- hero-section-form.blade.php
- testimonial-form.blade.php
- site-settings-form.blade.php (if it has textarea)

---

## 🔄 Replacement Code (for forms with single 'description' field):

```blade
@push('scripts')
<script>
    let editorInstance;

    document.addEventListener('livewire:initialized', function () {
        initializeCKEditor();
    });

    document.addEventListener('livewire:navigated', function () {
        initializeCKEditor();
    });

    function initializeCKEditor() {
        setTimeout(() => {
            if (typeof ClassicEditor !== 'undefined') {
                const element = document.querySelector('#description');
                if (element) {
                    if (editorInstance) {
                        editorInstance.destroy().catch(error => console.log(error));
                    }

                    ClassicEditor
                        .create(element, {
                            toolbar: ['undo', 'redo', '|', 'heading', '|', 'bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'link'],
                        })
                        .then(editor => {
                            editorInstance = editor;
                            const initialContent = @this.get('description') || '';
                            editor.setData(initialContent);
                            editor.model.document.on('change:data', () => {
                                @this.set('description', editor.getData());
                            });
                        })
                        .catch(error => console.error('CKEditor error:', error));
                }
            }
        }, 100);
    }

    document.addEventListener('livewire:navigating', function () {
        if (editorInstance) {
            editorInstance.destroy().catch(error => console.log(error));
        }
    });
</script>
@endpush
```

---

## ✨ All forms will now have beautiful rich text editors!
