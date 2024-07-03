<?php include 'include/header.php'; ?>
<style>
    .social_icons_styles {
        padding-left: 0px !important;
        padding-right: 0px !important;
        width: 8%;
    }

    .reffer-sec-1 {
        /* background:#3d78cb; */
        background: url(<?= base_url(); ?>asset/admin/img/Vector.png);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        text-align: center;
        padding: 30px 0px;
    }

    .reffer-sec-1 h1,
    .reffer-sec-1 p {
        color: #fff;
    }

    .user-id-logo {
        background: #f1f1f1;
        border-radius: 100px;
        padding: 10px;
        width: 63px;
        margin: auto;
        color: #000 !important;
    }

    .referal-copy {
        padding-top: 24px;
    }

    hr {
        margin: 10px 0px;
    }

    .referral-steps-1 {
        background: #fff;
    }

    .block-header {
        padding-top: 10px;
        padding-left: 10px;
    }

    .card {
        text-align: center;
        border: 1px solid #B1B1B1;
        border-radius: 5px;
        padding: 10px;
        margin-top: 10px;
    }

    .refer-content-head {
        padding: 0px 30px 40px 30px;
    }

    .card img {
        padding-bottom: 20px;
    }

    .referal-copy button {
        width: 100%;
    }

    .w-100 {
        width: 100% !important;
    }

    .m-0 {
        margin: 0 !important;
    }

    .p-0 {
        padding: 0 !important;
    }

    @media (width <=600px) {
        .reffer-sec-1 h1 {
            font-size: 20px;
        }

        .reffer-sec-1 p {
            font-size: 14px !important;
        }

        .reffer-sec-1 {
            background-position: right;
        }
    }

    .copy_code {
        padding: 0;
        margin: 0;
        background: none;
        font-size: 11px;
        color: #555;
    }
</style>
<?php





?>
<div class="acount-page membership-page">
    <div class="container">
        <div class="user-setting">
            <div class="row" style="display:flex;flex-wrap: wrap;">
                <div class="col-sm-3 new_referrl">
                    <?php include 'include/sidebar.php'; ?>
                </div>
                <!-- main content -->
                <?php
                $user_id = $this->session->user_id;
                $unique_id = $user_data['unique_id'];
                $type = $this->session->type;
                $url_h = base_url("signup?userid=$user_id%26unique_id=$unique_id%26user_type=$type");
                $url_t = base_url("signup-step1?userid=$user_id%26unique_id=$unique_id%26user_type=$type");
                $url_mh = base_url("signup?userid=$user_id&unique_id=$unique_id&user_type=$type");
                $url_mt = base_url("signup-step1?userid=$user_id&unique_id=$unique_id&user_type=$type");

                ?>
                <div class=" col-sm-9 new_referrl">
                    <section class="reffer-sec-1">

                        <h1>Invite a Friend & Earn Up to £15</h1>
                        <!-- <h1>Invite a Friend or a Trade & Earn Up to £15</h1> -->
                        <!-- <p style="font-size: 20px;">Introduce your friends to the easyest way to get things done</p> -->
                        <!-- <p style="font-size: 20px;">Introduce your friends to tradespeoplehub</p> -->
                        <!-- <p style="font-size: 20px;">If you enjoy Tradespeoplehub, share it with friends or a tradesperson to earn money.</p> -->
                        <?php if ($this->session->userdata('type') == 2) { ?>
                            <p style="font-size: 20px;">If you like Tradespeoplehub refer friends or homeowners and earn.</p>
                        <?php } else { ?>
                            <p style="font-size: 20px;">If you like Tradespeoplehub refer friends or trades and earn.</p>
                        <?php } ?>
                    </section>
                    <section style="background:#fff; padding-bottom:3px;margin:4px">
                        <h3 class="block-header">Shareable Links</h3>
                        <div style="padding-left: 9px; padding-bottom:10px; color: gray;">Copy your referral link below and share with your friends and followers who are homeowners or tradesman.</div>
                    </section>
                    <!-- <hr style="background:#fff; height:3px; width:100%;"> -->
                    <div class="row" style="background-color: white;padding: 25px;margin:4px;">
                        <label style="font-size: 17px;">Homeowner</label>
                        <?php
                        if (isset($linkSettings)) {
                            $referral_links_homeowner =  explode(",", $linkSettings["referral_links_homeowner"]);
                            foreach ($referral_links_homeowner as $key212 => $value212) {                                
                        ?>
                                <div class="row m-0 w-100" style="padding-bottom: 15px;">
                                    <div class="col-lg-7 p-0">
                                        <label style="position: absolute;right: 6px;top: -22px; font-size: 14px;font-weight: bold;">Copy Link</label>

                                        <span type="text" placeholder="" value="" name="" class="form-control input-md" style="font-size:11px;height:100%;">
                                            <?= $value212; ?>/?referral=<?= $unique_id; ?>
                                        </span>

                                        <input type="hidden" id="shared_url_hm_h<?= $key212 ?>" value="<?= $value212; ?>/?referral=<?= $unique_id; ?>">

                                        <button style="padding:0px 4px" class="btn copied_url" attr-id="shared_url_hm_h<?= $key212 ?>" data-toggle="popover" data-placement="top" data-trigger="focus"><i class="fa fa-clipboard" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="col-lg-5 reffer-share">
                                        <span><strong>Share on </strong></span>
                                        <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="<?= $value212; ?>?referral=<?= $unique_id; ?>" data-a2a-title=" -">
                                            <a class="a2a_button_facebook"></a>
                                            <a class="a2a_button_twitter"></a>
                                            <a class="a2a_button_email"></a>
                                            <a class="a2a_button_whatsapp"></a>
                                        </div>

                                    </div>
                                </div>
                        <?php }
                        } ?>
                    </div>
                    <!-- tradsman -->
                    <div class="row" style="background-color: white;padding: 20px;margin:2px;">
                        <label style="font-size: 17px;">Tradesman</label>
                        <?php
                        if (isset($linkSettings)) {
                            $referral_links_tradsman =  explode(",", $linkSettings["referral_links_tradsman"]);
                            foreach ($referral_links_tradsman as $key21221 => $value212) {
                        ?>
                                <div class="row m-0 w-100" style="padding-bottom: 15px;">
                                    <div class="col-lg-7 p-0">
                                        <label style="position: absolute;right: 6px;top: -22px; font-size: 14px;font-weight: bold;">Copy Link</label>
                                        <span type="text" placeholder="" value="" name="" class="form-control input-md" style="font-size:11px;height:100%;">
                                            <?= $value212; ?>/?referral=<?= $unique_id; ?>
                                        </span>
                                        <input type="hidden" id="shared_url_hm_t<?= $key21221; ?>" value="<?= $value212; ?>/?referral=<?= $unique_id; ?>">

                                        <button style="padding:0px 4px" class="btn copied_url" attr-id="shared_url_hm_t<?= $key21221; ?>" data-toggle="popover" data-placement="top" data-trigger="focus"><i class="fa fa-clipboard" aria-hidden="true"></i></button>
                                    </div>
                                    <div class="col-lg-5 reffer-share">
                                        <span><strong>Share on</strong></span>
                                        <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="<?= $value212; ?>?referral=<?= $unique_id; ?>" data-a2a-title=" -">
                                            <a class="a2a_button_facebook"></a>
                                            <a class="a2a_button_twitter"></a>
                                            <a class="a2a_button_email"></a>
                                            <a class="a2a_button_whatsapp"></a>
                                        </div>
                                    </div>
                                </div>
                        <?php }
                        }
                        ?>

                        <div class="row m-0 w-100" style="padding-bottom: 15px;">
                            <div class="col-lg-7 p-0">
                                <label style="position: absolute;right: 6px;top: -22px; font-size: 14px;font-weight: bold;">Copy Code</label>
                                <span type="text" placeholder="" value="" name="" class="form-control input-md" style="font-size:11px;height:100%;">
                                    <?= $unique_id; ?>
                                </span>
                                <input type="hidden" id="copy_code" value="<?= $unique_id; ?>">

                                <button style="padding:0px 4px" class="btn copied_url" data-toggle="popover" attr-id="copy_code" data-placement="top" data-trigger="focus"><i class="fa fa-clipboard" aria-hidden="true"></i></button>
                                
                            </div>
                            <div class="col-lg-5 reffer-share">
                                <span><strong>Share on</strong></span>
                                <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="-" data-a2a-title="<?= $unique_id; ?>">
                                    <a class="a2a_button_facebook"></a>
                                    <a class="a2a_button_twitter"></a>
                                    <a class="a2a_button_email"></a>
                                    <a class="a2a_button_whatsapp"></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- </section> -->
                    <section class="referral-steps-1">
                        <h3 class="block-header">How it works</h3>
                        <hr style="background:#fff; height:3px; width:100%;">
                        <div class="row" style="padding:30px;">
                            <div class="col-lg-4">
                                <div class="card">
                                    <img src="<?php echo base_url('asset/admin/img/Chat.png') ?>" alt="">

                                    <p>Spread the word by sharing a link with friends,trades or followers.</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card">
                                    <img src="<?php echo base_url('asset/admin/img/Group.png') ?>" alt="">

                                    <p>Your friend clicks on the shared link, sign up and post or quote a job.</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card">
                                    <img src="<?php echo base_url('asset/admin/img/Receive money.png') ?>" alt="">

                                    <?php if ($this->session->userdata('type') == 2) { ?>
                                        <p>You earn and use the earnings to fund your account and pay for quote.</p>
                                    <?php } else { ?>
                                        <p>You earn and withdraw the earnins or use it to pay for your project.</p>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>
                        <div class="refer-content-head">

                            <h1 class="text-center ">Don't Let Your Friends waste another minute</h1>

                            <p class="text-center">Nobody likes to waste time and money.Thats why we exist. You've experienced this power , now you can share it and earn up to £15 for every friend who signs up and post or quote a job. <a href="<?php echo base_url('terms-and-conditions#Tac21'); ?>">Terms & conditions</a> apply. </p>
                        </div>
                    </section>
                </div>

                <!-- main content  end here -->
            </div>
        </div>
    </div>
</div>
<script async src="https://static.addtoany.com/menu/page.js"></script>
<?php include 'include/footer.php'; ?>
<script>
    jQuery(document).ready(function() {
        jQuery(document).on("click", ".copied_url", function() {
            var attr_id = jQuery(this).attr('attr-id');

            var copyText = document.getElementById(attr_id);

            copyText.select();
            navigator.clipboard.writeText(copyText.value);
            // alert("Copied the Url");
        });
        jQuery(document).on("click", ".copy_code", function() {
            
            var attr_id = jQuery(this).attr('attr-id');
            var copyText = document.getElementById(attr_id);

            copyText.select();
            navigator.clipboard.writeText(copyText.value);
            // alert("Copied the Url");
        });

    });

    // $(function () {
    //     $('[data-toggle="popover"]').popover()
    // });

    $(document).ready(function() {
        $("[data-toggle='popover']").popover({
            html: 'true',
            content: '<div id="popOverBox">Copied!</div>'
        });
    });
</script>