'use strict';

jQuery(function($) {
    /* 
     * Form Elements 
     * ------------- 
     */

    var form = {
        elements: {
            form: '#author-report',
            error: '#author-error',
            input: '#author-report input:text'
        },
        validated: [],
        incomplete: 'Please fill in all form fields!',
        error: function(message) {
            // Write message to the error box.
            $(this.elements.error).append(message + '<br />');
            console.error(message);
        },
        validate: function(element) {
            // Validate each field input in turn using it's pattern regex.
            if ($(element).val().match($(element).attr('pattern'))) {
                this.validated.push(true);
            } else {
                var verb = $(element).attr('name').replace(/_.*$/, ''),
                    noun = $(element).attr('name').replace(/^.*_/, '');

                this.error('Error: ' + verb + ' ' + noun + ' must be a valid ' + noun);
                this.validated.push(false);
            }
        }
    };

    /* 
     * Form Functions 
     * -------------- 
     * Check an array of Booleans to see if its values are all true.
     */

    Array.prototype.allTrue = function() {
        for (var i = 0; i < this.length; i++) {
            if (!this[i]) {
                return false;
            }
        }

        return true;
    }

    /* 
     * Validation
     * ---------- 
     * Validate form inputs have been filled and contain valid numbers.
     */

    $(form.elements.form).submit(function(event) {
        form.validated = [];
        $(form.elements.error).empty();
        
        $(form.elements.input).each(function() {
            if ($(this).val().length == 0) {
                form.error(form.incomplete);
                return false;
            } else {
                form.validate(this);
            }
        });

        return (form.validated.allTrue() && form.validated.length == $(form.elements.input).length);
    });
});