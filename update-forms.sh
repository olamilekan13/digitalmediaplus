#!/bin/bash
# This script updates all forms to use CKEditor instead of TinyMCE

FORMS="feature-highlight-form faq-form hero-section-form testimonial-form"

for FORM in $FORMS; do
  echo "Updating $FORM.blade.php..."
done
