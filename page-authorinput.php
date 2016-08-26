<?php
/*
Template Name: Better Author Report
*/

get_header();
?>

    </header> 
    <div class="article-body">
        <?php  
        /* Author Report Input v2
        * ------------------------------
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
        */ 
        ?>
        <form id="author-report" method="post" action="<?php echo site_url() . '/author-output/'; ?>" novalidate>
            <p id="author-error"></p>
            <p>
                <strong>Start date:</strong><br />
                <input type="text" id="start-day" name="start_day" pattern="^([1-9]|[12]\d|3[01])$" placeholder="dd" size="2" width="2" required>
                <input type="text" id="start-month" name="start_month" pattern="^([1-9]{1})([0-2]{0,1})$" placeholder="mm" size="2" width="2" required>
                <input type="text" id="start-year" name="start_year" pattern="^(19|20)[0-9]{2}$" placeholder="yyyy" size="4" width="4" required>
            </p>
            <p>
                <strong>End date:</strong><br />
                <input type="text" id="end-day" name="end_day" pattern="^([1-9]|[12]\d|3[01])$" placeholder="dd" size="2" width="2" required>
                <input type="text" id="end-month" name="end_month" pattern="^([1-9]{1})([0-2]{0,1})$" placeholder="mm" size="2" width="2" required>
                <input type="text" id="end-year" name="end_year" pattern="^(19|20)[0-9]{2}$" placeholder="yyyy" size="4" width="4" required>
            </p>
            <input type="submit">
        </form>

     </div>
</article>

<?php printf('</div>');

if ($template != 'full') {
    get_sidebar();
} else {
    printf('<div class="clear"></div>');
}

printf('</div>');
get_footer(); ?>
