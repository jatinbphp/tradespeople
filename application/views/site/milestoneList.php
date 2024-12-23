<?php
	function ordinal1($number) {
		$suffixes = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
		if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
			return $number . 'th';
		} else {
			return $number . $suffixes[$number % 10];
		}
	}
	

	if(!empty($milestones)){
		$lastKey = array_key_last($milestones);
?>
		<?php foreach ($milestones as $key => $value): ?>
			<div class="row milestoneList">
				<div class="col-md-7">
					<?php echo ordinal1($key + 1); ?> Milestone - <?php echo $value['milestone_name']; ?>
				</div>
				<div class="col-md-2 text-right">
					<?php echo $value['delivery'].' days'?>
				</div>
				<div class="col-md-3 text-right">
					<?php echo '£'.number_format($value['total_amount'],2); ?>
				</div>
			</div>
		<?php endforeach; ?>

		<?php
	}
?>