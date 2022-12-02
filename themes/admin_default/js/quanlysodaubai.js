function nv_del_content(malop, checkss) {
  if (confirm(nv_is_del_confirm[0])) {
      $.post(script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable 
      + '=' + nv_module_name + '&' + nv_fc_variable + '=del&nocache=' + new Date().getTime(), 'malop=' + malop + '&checkss=' + checkss
      , function(res) {
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