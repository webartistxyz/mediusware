<?php $__env->startSection('content'); ?>
<div class="container-fluid app-body settings-page">
    <div>
		<h3>History </h3>
    	<history-data></history-data>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>