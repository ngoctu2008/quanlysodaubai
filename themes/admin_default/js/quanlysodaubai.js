function nv_del_class(classid, checkss) {
	if (confirm(nv_is_del_confirm[0])) {
		$.post(script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=delclass&nocache=' + new Date().getTime(), 'classid=' + classid + '&checkss=' + checkss, function(res) {
			var r_split = res.split("_");
			if (r_split[0] == 'OK') {
				window.location.href = script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=classlist';
			} else if (r_split[0] == 'ERR') {
				alert(r_split[1]);
			} else {
				alert(nv_is_del_confirm[2]);
			}
		});
	}
	return false;
}

function nv_del_student(studentid, classid, checkss) {
	if (confirm(nv_is_del_confirm[0])) {
		$.post(script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=delstudent&nocache=' + new Date().getTime(), 'studentid=' + studentid + '&checkss=' + checkss, function(res) {
			var r_split = res.split("_");
			if (r_split[0] == 'OK') {
				window.location.href = script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=studentlist&classlistid=' + classid;
			} else if (r_split[0] == 'ERR') {
				alert(r_split[1]);
			} else {
				alert(nv_is_del_confirm[2]);
			}
		});
	}
	return false;
}

function nv_del_headbook(masodaubai, manamhoc, matuan, malop, mabuoi, checkss) {
	if (confirm(nv_is_del_confirm[0])) {
		$.post(script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=delheadbook&nocache=' + new Date().getTime(), 'masodaubai=' + masodaubai + '&checkss=' + checkss, function(res) {
			var r_split = res.split("_");
			if (r_split[0] == 'OK') {
				window.location.href = script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=manageheadbook&manamhoc=' + manamhoc +'&matuan='+ matuan+'&malop='+malop+'&mabuoi='+mabuoi;
			} else if (r_split[0] == 'ERR') {
				alert(r_split[1]);
			} else {
				alert(nv_is_del_confirm[2]);
			}
		});
	}
	return false;
}

function nv_del_schoolyear(manamhoc, checkss) {
	if (confirm(nv_is_del_confirm[0])) {
		$.post(script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=delschoolyear&nocache=' + new Date().getTime(), 'manamhoc=' + manamhoc + '&checkss=' + checkss, function(res) {
			var r_split = res.split("_");
			if (r_split[0] == 'OK') {
				window.location.href = script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=schoolyearlist';
			} else if (r_split[0] == 'ERR') {
				alert(r_split[1]);
			} else {
				alert(nv_is_del_confirm[2]);
			}
		});
	}
	return false;
}


function nv_del_subject(subjectid, checkss) {
	if (confirm(nv_is_del_confirm[0])) {
		$.post(script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=delsubject&nocache=' + new Date().getTime(), 'subjectid=' + subjectid + '&checkss=' + checkss, function(res) {
			var r_split = res.split("_");
			if (r_split[0] == 'OK') {
				window.location.href = script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=subjectlist';
			} else if (r_split[0] == 'ERR') {
				alert(r_split[1]);
			} else {
				alert(nv_is_del_confirm[2]);
			}
		});
	}
	return false;
}


function change_subject(khoi) {
	var mamonhoc = $('#subject').val();
	$.ajax({url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=addheadbook&change_subject=1&mamonhoc=' + mamonhoc+'&khoi='+khoi, success: function(result){
		if (result != 'ERR') {
			$('#name_lesson').html(result);
		}
  }});
}

function change_name_lesson() {
	var mappct = $('#name_lesson').val();
	$.ajax({url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=addheadbook&change_name_lesson=1&mappct=' + mappct, success: function(result){
		if (result != 'ERR') {
			$("#lesson_number").val(result);
		}
  }});
}

function change_schoolyear() {
	var manamhoc = $('#schoolyear').val();
	$.ajax({url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=manageheadbook&change_schoolyear=1&manamhoc=' + manamhoc, success: function(result){
		if (result != 'ERR') {
			$("#week").append(result);
		}
  }});
}
