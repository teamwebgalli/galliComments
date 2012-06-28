//<script>
elgg.provide('elgg.galliComments');

elgg.galliComments.init = function() {
	var form = $('form[name=elgg_add_comment]');
	form.find('input[type=submit]').live('click', elgg.galliComments.submit);
};

elgg.galliComments.submit = function(e) {
	is_tinyMCE_active = false;
	if ((typeof tinyMCE != "undefined") && tinyMCE.activeEditor && !tinyMCE.activeEditor.isHidden()) {
		is_tinyMCE_active = true;
	}
	if (is_tinyMCE_active) {
		tinyMCE.triggerSave();
	}	
	var form = $(this).parents('form');
	var data = form.serialize();
	elgg.action('galliComments/add', {
		data: data,
		success: function(json) {
			var ul = $('ul.elgg-list-annotation');
			
			// allow plugins to prepend comment when annotations are ordered by 'time_created desc' || Or perform own action
			var orderBy = elgg.trigger_hook('getOptions', 'galliComments.submit', json.output, 'asc');
		
			if (orderBy ==  'asc') {
				if (ul.length < 1) {
					form.parent().prepend(json.output);
				} else {
					ul.append($(json.output).find('li:first'));
				}
			} else if (orderBy == 'desc') {
				if (ul.length < 1) {
					form.parent().append(json.output);
				} else {
					ul.prepend($(json.output).find('li:first'));
				}
			} // else if other than 'asc' or 'desc' lets plugin perform own action
			
			if (is_tinyMCE_active) {
				tinyMCE.activeEditor.setContent(''); 
			} else {	
				form.find('textarea').val('');
			}	
		}
	});
	e.preventDefault();
};
elgg.register_hook_handler('init', 'system', elgg.galliComments.init);