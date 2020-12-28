<?php $separator = " | "; ?>

<footer>
    <div>
        <hr>
        <b><?php _htmlsc($quote->user_name); ?></b>
        
        <?php 
        if ($quote->user_address_1) {
            echo $separator . htmlsc($quote->user_address_1);
        }

        if ($quote->user_address_2) {
            echo $separator . htmlsc($quote->user_address_2);
        }

        if ($quote->user_city || $quote->user_state || $quote->user_zip || $quote->user_counry) {
            echo $separator;
            
            if ($quote->user_zip) {
                echo htmlsc($quote->user_zip) . ' ';
            }
        
            if ($quote->user_city) {
                echo htmlsc($quote->user_city) . $separator;
            }
        
            if ($quote->user_state) {
                echo htmlsc($quote->user_state) . $separator;
            }
        
            if ($quote->user_country) {
                echo get_country_name(trans('cldr'), $quote->user_country);
            }
        }
        ?>
        </div>
        <div>

        <?php
        if ($quote->user_email) {
            echo '<a href="mailto:'.$quote->user_email.'">' .htmlsc($quote->user_email). '</a>';
        }
        if ($quote->user_mobile) {
            echo $separator.htmlsc($quote->user_mobile). ' ';
        }
        if ($quote->user_phone) {
            echo $separator.htmlsc($quote->user_phone). ' ';
        }
        if ($quote->user_fax) {
            echo $separator.htmlsc($quote->user_fax) . ' ';
        }
        if ($quote->user_web) {
            echo $separator.htmlsc($quote->user_web) . ' ';
        }
        ?>
        </div>
        <div>
        <?php
            if ($quote->user_vat_id) {
                echo trans('vat_id_short') . ': ' . $quote->user_vat_id . ' ';
            }

            if ($quote->user_tax_code) {
                echo trans('tax_code_short') . ': ' . $quote->user_tax_code . ' ';
            }
        ?>

        <?php
            if($quote->user_iban) {
                echo $separator .trans('user_iban').': '. $quote->user_iban . '';
            }
            if(isset($custom_fields['user']['bic'])) {
                echo $separator . $custom_fields['user']['bic'] . '';
            } 
        ?>
        <div class="pagination">{PAGENO}</div>
        </div>
</footer>