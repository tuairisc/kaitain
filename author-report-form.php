<?php
/*
Template Name: Monthly Author Report Form
*/
?>
<?php get_header(); ?>
<div id="main">
    <style type="text/css">
        div#content {
            width: 100%;
        }

        div.content-wrap {
            padding-top: 0;
        }
    </style>
    <div id="content">
            <div class="post clearfix">
                <div class="entry" id="author-report">
                    <h1>Author Posting Report</h1>
                    <?php  /* Author Report Input v1.0
                    * -------------------------
                    * This report was requested by Emer for accounting purposes. 
                    * In order to pay each author or contributor, Emer must see
                    * articles posted in an inclusive period, along with word count
                    * (and helpfully views) too. 
                    * 
                    * The author report currently outputs information in a tabulated 
                    * manner:
                    * 
                    * Author Name
                    * -----------
                    * Article ID | Article Title | Article Date | Views | Word Count
                    * 
                    * page-authorreport.php takes its input from page-authorform.php
                    * 
                    */ ?>
                    <form method="post" action="<?php echo site_url() . '/author-report/'; ?>" novalidate>
                        <p class="error"></p>
                        <p>
                            <?php // Form uses HTML5 input attributes, but I sanitize it with JS. ?>
                            <strong>Start date:</strong><br />
                            <input type="text" id="start-day"   name="start_day"   pattern="^([1-3]{1})([0-9]{0,1})$" placeholder="dd"   size="2" width="2" required>
                            <input type="text" id="start-month" name="start_month" pattern="^([1-9]{1})([0-2]{0,1})$" placeholder="mm"   size="2" width="2" required>
                            <input type="text" id="start-year"  name="start_year"  pattern="^(19|20)[0-9]{2}$"        placeholder="yyyy" size="4" width="4" required>
                        </p>
                        <p>
                            <strong>End date:</strong><br />
                            <input type="text" id="end-day"   name="end_day"   pattern="^([1-3]{1})([0-9]{0,1})$" placeholder="dd"   size="2" width="2" required>
                            <input type="text" id="end-month" name="end_month" pattern="^([1-9]{1})([0-2]{0,1})$" placeholder="mm"   size="2" width="2" required>
                            <input type="text" id="end-year"  name="end_year"  pattern="^(19|20)[0-9]{2}$"        placeholder="yyyy" size="4" width="4" required>
                        </p>
                        <input type="submit">
                    </form>
                    <script>
                        var form = {
                            id : '#author-report form',
                            error : '#author-report .error',
                            input : '#author-report input:text',
                        };

                        // Is the form validated?
                        var formValidated = false;

                        // Functions

                        Array.prototype.allTrue = function() {
                            // Have all elements in the array successfully validated?
                            for (var i = 0; i < this.length; i++) {
                                if (this[i] !== true) {
                                    return false;
                                }
                            }

                            return true;
                        }

                        function writeError(msg) {
                            // Write message to the error box.
                            jQuery(form.error).append(msg);
                        }

                        function validateInput(obj) {
                            // Validate each field input in turn using it's pattern regex.
                            var input = {
                                val   : jQuery(obj).val(),
                                regex : jQuery(obj).attr('pattern'),
                                name  : jQuery(obj).attr('name'),
                                phold : jQuery(obj).attr('placeholder')
                            };

                            if (!input.val.match(input.regex)) {
                                var verb = input.name.replace(/_.*$/, '');
                                var noun = input.name.replace(/^.*_/, ''); 
                                writeError('Error: ' + verb + ' ' + noun + ' must be a valid ' + noun + '<br />');
                                return false;
                            }

                            return true;
                        }

                        function toUnixTime(year, month, day, time) {
                            // Convert a given string to a date.
                            var string = year + '-' + month + '-' + day + ' ' + time;
                            return new Date(string).getTime() / 1000;
                        }

                        // Validation

                        jQuery(form.id).submit(function(click) {
                            // Results of input validation.
                            var validationResults = [];

                            jQuery(form.error).empty();
                            
                            jQuery(form.input).each(function() {
                                // Push input validation results to an array.
                                validationResults.push(validateInput(jQuery(this)));
                            });

                            if (validationResults.allTrue()) {
                                // ^If every input validated as true.
                                var startDate = toUnixTime(
                                    jQuery('#start-year').val(),
                                    jQuery('#start-month').val(),
                                    jQuery('#start-day').val(),
                                    '00:00:00'
                                );

                                var endDate = toUnixTime(
                                    jQuery('#end-year').val(),
                                    jQuery('#end-month').val(),
                                    jQuery('#end-day').val(),
                                    '23:59:59'
                                );

                                if (endDate > startDate) {
                                    formValidated = true;
                                } else {
                                    writeError('Error: end date may not be earlier than start date');
                                }
                            }

                            return formValidated;
                        });
                    </script>
                </div><!-- / .entry -->
                <div class="clear"></div>
            </div><!-- /.post -->
    </div><!-- /#content -->
</div><!-- /#main -->
<?php get_footer(); ?>