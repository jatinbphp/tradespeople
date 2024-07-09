<?php if(isset($categories_data) && !empty($categories_data)): ?>
    <div class="categories-menu-main">
        <div class="container">
            <nav class="scroll-container categories-menu">
                <button id="scroll-left" class="scroll-btn left" style="top:0;">
                    <span class="icon-chevron">
                        <svg width="8" height="15" viewBox="0 0 8 15" xmlns="http://www.w3.org/2000/svg"><path d="M7.2279 0.690653L7.84662 1.30934C7.99306 1.45578 7.99306 1.69322 7.84662 1.83968L2.19978 7.5L7.84662 13.1603C7.99306 13.3067 7.99306 13.5442 7.84662 13.6907L7.2279 14.3094C7.08147 14.4558 6.84403 14.4558 6.69756 14.3094L0.153374 7.76518C0.00693607 7.61875 0.00693607 7.38131 0.153374 7.23484L6.69756 0.690653C6.84403 0.544184 7.08147 0.544184 7.2279 0.690653Z"></path></svg>
                    </span>
                </button>
                <ul class="scroll-list categories">
                    <?php foreach($categories_data as $data): ?>
                        <li>
                            <a href="<?php echo site_url('category/'.($data['slug'] ?? '')) ?>"><?php echo ($data['cat_name'] ?? '') ?></a>
                            <?php if(isset($data['chiled']) && count($data['chiled'])): ?>
                                <ul class="menu-panel">
                                    <?php foreach($data['chiled'] as $chiledData): ?>
                                        <li>
                                            <a href="<?php echo site_url('category/'.($data['slug'] ?? '').'/'.($chiledData['slug'] ?? '')) ?>"><?php echo ($chiledData['cat_name'] ?? '') ?></a>
                                            <?php if(isset($chiledData['chiled']) && count($chiledData['chiled'])): ?>
                                                <ul class="sub-menu-panel">
                                                        <?php foreach($chiledData['chiled'] as $chiled): ?>
                                                            <li><a href="<?php echo site_url('category/'.($data['slug'] ?? '').'/'.($chiledData['slug'] ?? '').'/'.($chiled['slug'] ?? '')) ?>"><?php echo ($chiled['cat_name'] ?? '') ?></a></li>
                                                        <?php endforeach; ?>
                                                </ul>
                                                <?php else: ?>
                                                    <ul class="sub-menu-panel">
                                                        <li>-</li>
                                                    </ul>
                                            <?php endif ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <button id="scroll-right" class="scroll-btn right" style="top:0;">
                    <span class="icon-chevron">
                        <svg width="8" height="16" viewBox="0 0 8 16" xmlns="http://www.w3.org/2000/svg"><path d="M0.772126 1.19065L0.153407 1.80934C0.00696973 1.95578 0.00696973 2.19322 0.153407 2.33969L5.80025 8L0.153407 13.6603C0.00696973 13.8067 0.00696973 14.0442 0.153407 14.1907L0.772126 14.8094C0.918563 14.9558 1.156 14.9558 1.30247 14.8094L7.84666 8.26519C7.99309 8.11875 7.99309 7.88131 7.84666 7.73484L1.30247 1.19065C1.156 1.04419 0.918563 1.04419 0.772126 1.19065Z"></path></svg>
                    </span>	
                </button>
            </nav>
        </div>
    </div>
<?php endif ?>

<script type="text/javascript">
    $(document).ready(function() {
        var scrollContainer = $('.scroll-list');
        var scrollLeftBtn = $('#scroll-left');
        var scrollRightBtn = $('#scroll-right');

        function updateButtons() {
            if (scrollContainer.scrollLeft() <= 0) {
                scrollLeftBtn.addClass('hidden');
            } else {
                scrollLeftBtn.removeClass('hidden');
            }

            if (scrollContainer[0].scrollWidth - scrollContainer.outerWidth() <= scrollContainer.scrollLeft()) {
                scrollRightBtn.addClass('hidden');
            } else {
                scrollRightBtn.removeClass('hidden');
            }
        }

        scrollLeftBtn.on('click', function() {
            var containerWidth = scrollContainer.width();
            var deduction = (scrollContainer.width() / 6) ;
            console.log(containerWidth);
            scrollContainer.animate({
                scrollLeft: '-='+ (containerWidth - deduction)
            }, 'smooth');
        });

        scrollRightBtn.on('click', function() {
            var containerWidth = scrollContainer.width();
            var deduction = (scrollContainer.width() / 6) ;
            scrollContainer.animate({
                scrollLeft: '+='+ (containerWidth - deduction)
            }, 'smooth');
        });

        scrollContainer.on('scroll', updateButtons);

        updateButtons();
    });
</script>