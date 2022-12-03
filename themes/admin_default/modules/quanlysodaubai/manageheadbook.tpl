<!-- BEGIN: manageheadbook -->
    <form action="" method="post" class="form-inline">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
    <tr class="text-center">
      <th rowspan="2" align="center" style="vertical-align:middle; text-align:center;">{LANG.day}</th>
      <th rowspan="2" align="center" style="vertical-align:middle;text-align:center;">{LANG.lesson}</th>
      <th rowspan="2" align="center" style="vertical-align:middle;text-align:center;">{LANG.subject}</th>
      <th rowspan="2" align="center" style="vertical-align:middle;text-align:center;">{LANG.lesson_program}</th>
      <th rowspan="2" align="center" style="vertical-align:middle;text-align:center;">{LANG.student_absent}</th>
      <th rowspan="2" align="center" style="vertical-align:middle;text-align:center;">{LANG.name_lesson}</th>
      <th rowspan="2" align="center" style="vertical-align:middle;text-align:center;">{LANG.comment}</th>
      <th colspan="3" align="center" style="vertical-align:middle;text-align:center;">{LANG.mark}</th>
      <th rowspan="2" align="center" style="vertical-align:middle;text-align:center;">{LANG.total_point}</th>
      <th rowspan="2" align="center" style="vertical-align:middle;text-align:center;" >{LANG.teacher_sign}</th>
      <th rowspan="2" align="center" style="vertical-align:middle;text-align:center;" >{LANG.func}</th>
    </tr>
    <tr>
      <td>{LANG.study}</td>

      <td>{LANG.discipline}</td>
      <td>{LANG.clean}</td>
    </tr>

    <!-- BEGIN: loopday -->
    <!-- BEGIN: looplesson -->
    <tr>
      {DAY}
      <td align="center">{LESSON}
      </td>
      <td>
        {DATA.mamon}
        <a href="{DATA.add_url}" class="btn btn-success btn-xs" style="display:{DISPLAY_ADD}"><i class="fa fa-fw fa-plus"></i></a>
      </td>
      <td>{DATA.tietppct}</td>
      <td>{DATA.hocsinhvang}</td>
      <td>{DATA.tenbaihoc}</td>
      <td>{DATA.nhanxet}</td>
      <td>{DATA.diemhoctap}</td>
      <td>{DATA.diemkyluat}</td>
      <td>{DATA.diemvesinh}</td>
      <td>{DATA.tongdiem}</td>
      <td class="text-center">
        <img src="{DATA.giaovienbmkiten}" class="content-image" height="50" width="100" style="display:{DISPLAY_IMG}">
        </td>
      <td class="text-center">
        <a href="{DATA.edit_url}" class="btn btn-default btn-xs"  style="display:{DISPLAY_EDIT}"><i class="fa fa-fw fa-edit"></i></a>
        <a class="btn btn-danger btn-xs" href="javascript:void(0);" onclick="nv_del_headbook({DATA.masodaubai}, '{DATA.checksess}')" style="display:{DISPLAY_EDIT}"><i class="fa fa-fw fa-trash"></i></a>
      </td>
    </tr>
    <!-- END: looplesson -->
    <!-- END: loopday -->
  </table>
		</div>
    <div class="text-center">
        <input class="btn btn-primary" type="submit" name="btnsubmit" value="{LANG.week_summary}">
    </div>
	</form>
<!-- END: manageheadbook -->
