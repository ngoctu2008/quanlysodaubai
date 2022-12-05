<!-- BEGIN: addweek -->
<link rel="stylesheet" type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css">

    <form action="" method="post" class="form-inline">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
				<colgroup>
					<col style="width: 260px" />
					<col/>
				</colgroup>
				<tbody>
                    <tr>
                        <td>{LANG.schoolyear} <span class="red">*</span></td>
                        <td>
                        <input class="form-control w100" name="tunam" value="{DATA.tunam}" />
                        <span class="ml-10 mr-10"> - </span>
                        <input class="form-control w100" name="dennam" value="{DATA.dennam}" />
                        </td>
                    </tr>
                    <tr>
                        <td>{LANG.starttime} <span class="red">*</span></td>
                        <td>
                            <span class="text-middle">
                                <input class="form-control" name="thoigianbatdau" id="starttime" value="{DATA.thoigianbatdau}" style="width: 100px;" maxlength="10" type="text" />
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>{LANG.finishtime} <span class="red">*</span></td>
                        <td>
                            <span class="text-middle">
                                <input class="form-control" name="thoigianketthuc" id="finishtime" value="{DATA.thoigianketthuc}" style="width: 100px;" maxlength="10" type="text" />
                            </span>
                        </td>
                    </tr>
				</tbody>
			</table>
		</div>
    <div class="text-center">
        <input class="btn btn-primary" type="submit" name="btnsubmit" value="{LANG.save}">
    </div>
	</form>
   <script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript">
    $("#starttime,#finishtime").datepicker({
        showOn : "both",
        dateFormat : "dd/mm/yy",
        changeMonth : true,
        changeYear : true,
        showOtherMonths : true,
        buttonImage : nv_base_siteurl + "assets/images/calendar.gif",
        buttonImageOnly : true,
        yearRange: "-10:+10"
    });
</script>
<!-- END: addweek -->
