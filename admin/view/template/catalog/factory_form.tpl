<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-information" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-information" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-keyword">工厂名字</label>
                <div class="col-sm-10">
                  <input type="text" name="factory_name" value="<?php echo $factory_name; ?>" id="input-keyword" class="form-control" />
                  <?php if ($error_factory_name) { ?>
                  <div class="text-danger"><?php echo $error_factory_name; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status">选择省</label>
                <div class="col-sm-10">
                  <select name="province_code" id="input-status" class="form-control">
                    <?php foreach($areas as $area) { ?>
                      <?php if ($province_code == $area['area_code']) { ?>
                    <option value="<?php echo $area['area_code'];?>" selected="selected"><?php echo $area['area_name'];?></option>
                      <?php } else { ?>
                    <option value="<?php echo $area['area_code'];?>"><?php echo $area['area_name'];?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-keyword">地名</label>
                <div class="col-sm-10">
                  <input type="text" name="area_name" value="<?php echo $area_name; ?>" id="input-area-name" class="form-control" />
                </div>
              </div>
              <div class="form-group hidden">
                <label class="col-sm-2 control-label" for="input-status">选择地区</label>
                <div class="col-sm-10">
                  <select name="china_area_id" id="input-status" class="form-control">
                    <?php foreach($china_areas as $area) { ?>
                    <?php if ($china_area_id == $area['china_area_id']) { ?>
                    <option value="<?php echo $area['china_area_id'];?>" selected="selected"><?php echo $area['china_area_name'];?></option>
                    <?php } else { ?>
                    <option value="<?php echo $area['china_area_id'];?>"><?php echo $area['china_area_name'];?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="数字越小靠前" id="input-sort-order" class="form-control" />
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