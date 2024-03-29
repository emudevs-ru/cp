<fieldset>
  <legend><?=$text_captcha?></legend>
  <div class="form-group required">
    <?php if (route.slice(0, 9) == 'checkout/') { ?>
    <label class="control-label" for="input-payment-captcha"><?=$entry_captcha?></label>
    <input type="text" name="captcha" id="input-payment-captcha" class="form-control" autocomplete="off" />
    <img src="index.php?route=extension/captcha/basic/captcha" alt="" />
    <?php } else { ?>
    <label class="col-sm-2 control-label" for="input-captcha"><?=$entry_captcha?></label>
    <div class="col-sm-10">
      <input type="text" name="captcha" id="input-captcha" class="form-control" />
      <img src="index.php?route=extension/captcha/basic/captcha" alt="" />
      <?php if($error_captcha) { ?>
      <div class="text-danger"><?=$error_captcha?></div>
      <?php } ?>
    </div>
    <?php } ?>
  </div>
</fieldset>
