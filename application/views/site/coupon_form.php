<div class="form-group">
    <label for="code">Code:</label>
    <input type="text" name="code" class="form-control" value="<?php echo ($coupon['code'] ??  '') ?>" placeholder="Enter Code">
</div>
<div class="form-group">
    <label for="is_limited"> Select Is Limited:</label>
    <select name="is_limited" data-id="<?php echo $coupon['id'] ?? 0 ?>" class="form-control is-limited-user-selection">
        <option value="">Select</option>
        <option <?php echo (isset($coupon['is_limited']) && $coupon['is_limited'] == 'yes') ? 'selected' : '' ?> value="yes">Yes</option>
        <option <?php echo (isset($coupon['is_limited']) && $coupon['is_limited'] == 'no') ? 'selected' : '' ?> value="no">No</option>
    </select>
</div>
<div class="form-group limited_user_filed_<?php echo $coupon['id'] ?? 0 ?>" style="<?php echo (((isset($coupon) && $coupon['is_limited'] == 'no' || !isset($coupon['is_limited']))) ? 'display:none' : '') ?>">
    <label for="limited_user">Limited User:</label>
    <input type="number" min="1" step="1" name="limited_user" class="form-control" value="<?php echo ($coupon['limited_user'] ??  '') ?>" placeholder="Enter User Count">
</div>
<div class="form-group">
    <label for="discount_type"> Select Discount type:</label>
    <select name="discount_type" id="discount_type" class="form-control">
        <option value="">Select</option>
        <option <?php echo (isset($coupon['discount_type']) && $coupon['discount_type'] == 'percentage') ? 'selected' : '' ?> value="percentage">Percenage</option>
        <option <?php echo (isset($coupon['discount_type']) && $coupon['discount_type'] == 'flat') ? 'selected' : '' ?> value="flat">Flat</option>
    </select>
</div>
<div class="form-group">
    <label for="discount">Discount:</label>
    <input type="number" min="1" step="1" name="discount" class="form-control" value="<?php echo ($coupon['discount'] ??  '') ?>" placeholder="Enter Discount">
</div>
<div class="form-group">
    <label for="status"> Select Status:</label>
    <select name="status"  class="form-control">
        <option value="">Select</option>
        <option <?php echo (isset($coupon['status']) && $coupon['status'] == 'active') ? 'selected' : '' ?> value="active">Active</option>
        <option <?php echo (isset($coupon['status']) && $coupon['status'] == 'inactive') ? 'selected' : '' ?> value="inactive">Inactive</option>
    </select>
</div>