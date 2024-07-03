<?php $page_name=$this->uri->segment(1); ?>
<?php $post_id=$_REQUEST['post_id']; ?>
    <style type="text/css">
        .gray-head1
        {
            background-color: #f1f1f1;

        }
        #liskk2 li a
        {
            color:#333;
            font-weight: bolder;
        }
    </style>
<div class="gray-head1">
        <div class="container">   
        <div class="liskk2" id="liskk2" >
       
            <ul class="ul_set">
                <li class="active"><a href="<?php echo base_url('my-posts'); ?>">Open</a></li>
                <li><a href="<?php echo base_url('in-progress'); ?>">Work in Progress</a></li>
                <li><a href="<?php echo base_url('completed-jobs'); ?>">Completed</a></li>
                <li><a href="<?php echo base_url('rejected-jobs'); ?>">Rejected</a></li>
            </ul>

        </div>
    </div>
</div>

<script type="text/javascript">
     $(function(){

        $('.liskk2 a').filter(function(){return this.href==location.href}).parent().addClass('active').siblings().removeClass('active')


    })
</script>