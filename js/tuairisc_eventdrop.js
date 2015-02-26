'use strict';

jQuery(function($) {
    var dropbox = {
        input: '.event-drop',
        drag: 'file-drag',
        output: 'textarea[class=event-output]',
    }

    var provinces = [
        'Connacht',
        'Lenister',
        'Munster',
        'Ulster'
    ];

    String.prototype.sanitize = function() {
        // Remove HTML and line breaks from the user-submitted string.
        return this.replace(/\r?\n|\r/g,'').replace(/<(?:.|\n)*?>/gm, '');
    }

    var output = {
        // Treating the output value as an array will grant me more fluidity if
        // ever I find myself in a position where I have to edit its content. 
        result: [],
        add: function(tag, string, addClosingTag) {
            /*
             * Add Output HTML
             * ---------------
             * This was easier on my sanity than a run-on mess of '' + ''. 
             * Accepts three variables, two of them optional:
             * HTML tag (string, required), message (string, optional) and 
             * whether to add the closing tag (Boolean, optional). 
             */

            var html = '';
            string = string || '';
            addClosingTag = (addClosingTag !== false) ? true : addClosingTag;

            html += tag;
            html += string;
            html += (addClosingTag) ? tag.replace('<', '</').replace(/\sclass=.*/, '>') : '';
            html += '\n';

            this.result.push(html);
        },
        getHtml: function() {
            return this.result.join('');
        }, 
        elements: {
            /* 
             * Output HTML Elements
             * --------------------
             * Only JSON keys here will be output in the final HTML. This gives
             * you a measure of control over the final appearance, as well as
             * reduce the amount of work needed in the case that the form is
             * later changed.
             */

            eventType: '<h5>',
            eventTitle: '<h1>',
            entryFee: '<span class="entry-fee">',
            contactName: '<span class="contact-name">',
            contactInformation: '<span class="contact-information">',
            location: '<span class="location">',
            county: '<span class="county">',
            eventDescription: '<p class="description">',
            startDate: '<span class="start-date">',
            time: '<span class="time">',
            endDate: '<span class="end-date>'
        }
    }

    function getJsonKeysFromCsv(string) {
        // Parse CSV header line into JSON keys. 
        string = string.replace(/\s/, '').replace(/\s.*/, '').replace(/"/g,'');
        string = string.charAt(0).toLowerCase() + string.substr(1);
        string = string.replace('#', 'id').replace('"', '');
        return string;
    }

    function csvRowtoJson(header, row) {
        // Parse each given row string into a valid JSON object.

        var json = '{ ';
        // Remove all line break from the CSV
        row = row.sanitize().split('","');

        $.each(row, function(i,v) {
            // Sanitize extra quotation marks from each row item.
            row[i] = v.replace('"', '');
        });

        $.each(header, function(i,v) {
            json += '"' + v + '":';
            json += '"' + row[i] + '"';

            if (i < header.length - 1) {
                json += ',';
            }
        });

        json += ' }';

        return JSON.parse(json);
    }

    function getProvinceFromCounty(county) {
        // Get the province of a given county and return it.
        var province = '';

        switch (county.toLowerCase()) {
            case 'galway':
            case 'leitrim':
            case 'mayo':
            case 'roscommon':
            case 'sligo':
                province = provinces[0]; break;
            case 'clare':
            case 'cork':
            case 'kerry':
            case 'limerick':
            case 'tipperary':
            case 'waterford':
                province = provinces[1]; break;
            case 'antrim':
            case 'armagh':
            case 'cavan':
            case 'donegal':
            case 'down':
            case 'fermanagh':
            case 'derry':
            case 'monaghan':
            case 'tyrone':
                province = provinces[2]; break;
            case 'carlow':
            case 'dublin':
            case 'kildare':
            case 'kilkenny':
            case 'laois':
            case 'longford':
            case 'louth':
            case 'meath':
            case 'offaly':
            case 'westmeath':
            case 'wexford':
            case 'wicklow':
                province = provinces[3]; break;
            default:
                break;
        }

        return province;
    }

    function generateOutputHtml(provinces, events) {
        /*
         * Generate Output HTML
         * --------------------
         * Generate the output HTML. If the form is ever changed, this section
         * will need to be updated to reflect changes made.
         * 
         * Three level loop:
         * 
         * 1. Loop provinces.
         * 2. For each province, loop events.
         * 3. For each event, if it matches the province, loop it.
         * 3. For each event entry, if it isn't empty and has a supplied output 
         *    element, grab the HTML and add it.
         */

        for (var i = 0; i < provinces.length; i++) {
            output.add('<h2>', provinces[i]);

            $.each(events, function(k,v) {
                if (v.province === provinces[i]) {
                    output.add('<div class="event">', '', false);

                    $.each(v, function(k,v) {
                        if (v && output.elements[k]) {
                            output.add(output.elements[k], v);
                        }
                    });

                    output.add('</div>', '', false);
                }
            });
        }
    }

    function workMagic(file) {
        var reader = new FileReader();

        reader.onload = function(event) {
            /* 
             * Magic
             * -----
             * The magic happens here:
             * 
             * 1. Turn head row into JSON keys.
             * 2. Turn each other row into a JSON object.
             * 3. Push all JSON objects into an array.
             * 4. Add the correct province to each object.
             * 5. Loop through all objects by province and generate their HTML.
             */

            output.value = '';

            var rawCsv = event.target.result.split(/"\n/),
                header = [], events = [];

            $.each(rawCsv[0].split(','), function(i,v) {
                // Turn header row into JSON keys.
                header.push(getJsonKeysFromCsv(v));
            });

            $.each(rawCsv, function(i,v) {
                // Parse each subsequent CSV record into a JSON record.
                if (i > 0 && v) { 
                    events.push(csvRowtoJson(header, v));
                }
            });

            $.each(events, function(i, v) {
                // Add the correct province to each object.
                events[i].province = getProvinceFromCounty(v.county);
            });

            // Generate output HTML.
            generateOutputHtml(provinces, events);
            // Insert the HTML into the output textarea.
            $(dropbox.output).val(output.getHtml());
        }

        reader.onerror = function(error) {
            $(dropbox.output).val(error);
            console.error(error);
        }

        reader.readAsText(file[0]);
    }

    if (window.File && window.FileList && window.FileReader && dropbox.input.length > 0) {
        /*
         * Override default drag and drop actions so the magic can happen.
         * ---------------------------------------------------------------
         */

        $(dropbox.input).on('dragover', function(event) {
            event.stopPropagation();
            event.preventDefault();
            $(this).addClass(dropbox.drag);
        });

        $(dropbox.input).on('dragleave', function(event) {
            event.stopPropagation();
            event.preventDefault();
            $(this).removeClass(dropbox.drag);
        });

        $(dropbox.input).on('drop', function(event) {
            event.stopPropagation();
            event.preventDefault();
            $(this).removeClass(dropbox.drag);

            if (event.originalEvent.dataTransfer.files[0].type === 'text/csv') {
                // \o/ Magic \o/
                workMagic(event.originalEvent.dataTransfer.files);
            } else {
                return false;
            }
        });

        $(dropbox.output).focus(function() {
            this.setSelectionRange(0, this.value.length);
        })
    } else {
        $(dropbox.input).remove();
        $(dropbox.output).remove();
    }
});