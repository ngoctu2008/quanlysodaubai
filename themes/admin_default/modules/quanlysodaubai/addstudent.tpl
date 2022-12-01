<!-- BEGIN: addstudent -->
<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css">

<div id="edit">
    <!-- BEGIN: error -->
    <div class="alert alert-danger">
        {error}
    </div>
    <!-- END: error -->

    <form action="" method="post">
        <table class="table table-striped table-bordered table-hover">
            <tbody>
                <tr>
                    <td>{LANG.fullname} <span class="red">*</span></td>
                    <td>
                        <input class="form-control w400" name="hoten" type="text" value="{DATA.hoten}" maxlength="255" />
                    </td>
                </tr>
                <tr class="form-inline">
                    <td>{LANG.birthday} <span class="red">*</span></td>
                    <td>
                        <span class="text-middle">
                            <input class="form-control" name="ngaysinh" id="dayparty" value="{DATA.ngaysinh}" style="width: 100px;" maxlength="10" type="text" />
                        </span>
                    </td>
                </tr>
                <tr class="form-inline">
                    <td>{LANG.sex} <span class="red">*</span></td>
                    <td>
                        <select class="form-control w150" name="sex_{DATA_SEX.key}">
                                <!-- BEGIN: loopsex -->
                                <option value="{DATA_SEX.key}" {DATA_SEX.selected}>{DATA_SEX.title}</option>
                                <!-- END: loopsex -->
                        </select>
                    </td>
                </tr>
               <tr class="form-inline">
                    <td>{LANG.class} <span class="red">*</span></td>
                    <td>
                        <select class="form-control w100" name="class_{DATA_CLASS.key}">
                                <!-- BEGIN: loopclass -->
                                <option value="{DATA_CLASS.key}" {DATA_CLASS.selected}>{DATA_CLASS.title}</option>
                                <!-- END: loopclass -->
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>{LANG.numberabsent} <span class="red">*</span></td>
                    <td>
                    <input class="form-control w400" name="sotietnghi" type="text" value="{DATA.sotietnghi}" maxlength="255" />
                    </td>
                </tr>
                <tr>
                    <td>{LANG.avatar} <span class="red">*</span></td>
                    <td>
                    <input class="form-control w400 pull-left" style="margin-right: 5px" name="anhdaidien" id="anhdaidien" type="text" value="{DATA.anhdaidien}" maxlength="255" />
                    <input type="button" class="btn btn-primary" value="Browse server" name="selectimg"/>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="text-center">
        <input class="btn btn-primary" type="submit" name="btnsubmit" value="{LANG.save}">
        </div>
    </form>
</div>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript">
    //<![CDATA[
    var area = "anhdaidien";
    var path = "{NV_UPLOADS_DIR}/{module_name}";
    var currentpath = "{UPLOAD_CURRENT}";
    var type = "image";

    $("#birthday,#dayinto,#dayparty").datepicker({
        showOn : "both",
        dateFormat : "dd/mm/yy",
        changeMonth : true,
        changeYear : true,
        showOtherMonths : true,
        buttonImage : nv_base_siteurl + "assets/images/calendar.gif",
        buttonImageOnly : true,
        yearRange: "-90:+0"
    });
    //]]>
</script>
<!-- END: addstudent -->
