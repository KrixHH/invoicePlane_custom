<?php $separator = " | "; ?>

<footer>
    <div>
        <hr>
        <b><?php _htmlsc($invoice->user_name); ?></b>
        
        <?php 
        if ($invoice->user_address_1) {
            echo $separator . htmlsc($invoice->user_address_1);
        }

        if ($invoice->user_address_2) {
            echo $separator . htmlsc($invoice->user_address_2);
        }

        if ($invoice->user_city || $invoice->user_state || $invoice->user_zip || $invoice->user_counry) {
            echo $separator;
            
            if ($invoice->user_zip) {
                echo htmlsc($invoice->user_zip) . ' ';
            }
        
            if ($invoice->user_city) {
                echo htmlsc($invoice->user_city) . $separator;
            }
        
            if ($invoice->user_state) {
                echo htmlsc($invoice->user_state) . $separator;
            }
        
            if ($invoice->user_country) {
                echo get_country_name(trans('cldr'), $invoice->user_country);
            }
        }
        ?>
        </div>
        <div>

        <?php
        if ($invoice->user_email) {
            echo '<a href="mailto:'.$invoice->user_email.'">' .htmlsc($invoice->user_email). '</a>';
        }
        if ($invoice->user_mobile) {
            echo $separator.htmlsc($invoice->user_mobile). ' ';
        }
        if ($invoice->user_phone) {
            echo $separator.htmlsc($invoice->user_phone). ' ';
        }
        if ($invoice->user_fax) {
            echo $separator.htmlsc($invoice->user_fax) . ' ';
        }
        if ($invoice->user_web) {
            echo $separator.htmlsc($invoice->user_web) . ' ';
        }
        ?>
        </div>
        <div>
        <?php
            if ($invoice->user_vat_id) {
                echo trans('vat_id_short') . ': ' . $invoice->user_vat_id . ' ';
            }

            if ($invoice->user_tax_code) {
                echo trans('tax_code_short') . ': ' . $invoice->user_tax_code . ' ';
            }
        ?>

        <?php
            if($invoice->user_iban) {
                echo $separator .trans('user_iban').': '. $invoice->user_iban . '';
            }
            if(isset($custom_fields['user']['bic'])) {
                echo $separator . $custom_fields['user']['bic'] . '';
            } 
        ?>
        <div class="pagination">{PAGENO}</div>
        </div>
</footer>