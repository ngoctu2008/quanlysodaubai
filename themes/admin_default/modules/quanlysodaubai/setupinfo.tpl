<!-- BEGIN: setupinfo -->
	<form action="" method="post" class="form-inline">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
				<colgroup>
					<col style="width: 260px" />
					<col/>
				</colgroup>
				<tbody>
                    <tr>
						<td>{LANG.departmentname} <span class="red">*</span></td>
						<td><input class="form-control w400" name="tenso" value="{DATA.tenso}" /></td>
					</tr>
                    <tr>
						<td>{LANG.roomname} <span class="red">*</span></td>
						<td><input class="form-control w400" name="phong" value="{DATA.phong}" /></td>
					</tr>
					<tr>
						<td>{LANG.schoolname} <span class="red">*</span></td>
						<td><input class="form-control w400" name="truong" value="{DATA.truong}" /></td>
					</tr>
          <tr>
						<td>{LANG.schoolyear} <span class="red">*</span></td>
						<td>
              <input class="form-control w100" name="tunam" value="{DATA.tunam}" />
              <span class="ml-10 mr-10"> - </span>
              <input class="form-control w100" name="dennam" value="{DATA.dennam}" />
            </td>
					</tr>
				</tbody>
			</table>
		</div>
    <div class="text-center">
        <input class="btn btn-primary" type="submit" name="btnsubmit" value="{LANG.save}">
    </div>
	</form>
<!-- END: setupinfo -->
