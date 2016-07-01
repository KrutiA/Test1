<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-weight" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-weight" class="form-horizontal">
		 <input type="hidden" name="name" value="mailchimpsubscription" id="input-name" class="form-control" />
          <div class="row">
            <div class="col-sm-10">
              <div class="tab-content">
                <div class="tab-pane active" id="tab-general">
				<div class="form-group">
                    <label class="col-sm-2 control-label" for="mailchimp_api_key"><?php echo $entry_mailchimp_api_key; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="mailchimp_api_key" value="<?php echo $mailchimp_api_key; ?>" placeholder="<?php echo $entry_mailchimp_api_key; ?>" id="mailchimp_api_key" class="form-control" />
                    </div>
                  </div>
				  <div class="form-group">
                    <label class="col-sm-2 control-label" for="mc_list_id1"><?php echo $entry_list_id1; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="mc_list_id1" value="<?php echo $mc_list_id1; ?>" placeholder="<?php echo $entry_list_id1; ?>" id="mc_list_id1" class="form-control" />
                    </div>
                  </div>
				  <div class="form-group">
                    <label class="col-sm-2 control-label" for="mc_list_id2"><?php echo $entry_list_id2; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="mc_list_id2" value="<?php echo $mc_list_id2; ?>" placeholder="<?php echo $entry_list_id2; ?>" id="mc_list_id2" class="form-control" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                    <div class="col-sm-10">
                      <select name="status" id="input-status" class="form-control">
                        <?php if ($status) { ?>
                        <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                        <option value="0"><?php echo $text_disabled; ?></option>
                        <?php } else { ?>
                        <option value="1"><?php echo $text_enabled; ?></option>
                        <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?> 