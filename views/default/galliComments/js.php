//<script>
elgg.provide('elgg.galliComments');

elgg.galliComments.init = function() {
	$('.elgg-form-comment-save, #group-replies').find('input[type=submit]').on('click', elgg.galliComments.submit);
};

elgg.galliComments.submit = function(e) {
	e.preventDefault();

	is_tinymce_active = false;
	if ((typeof tinymce != "undefined") && tinymce.activeEditor && !tinymce.activeEditor.isHidden()) {
		is_tinymce_active = true;
	}
	if (is_tinymce_active) {
		tinymce.triggerSave();
	}
	var form = $(this).parents('form');
	var riverId = form.find('input[name=river_id]').val();
	var data = form.serialize();
	var ul_comments = $('.elgg-comments > ul.elgg-list, .elgg-comments > .elgg-list-container > ul.elgg-list');
	var ul_replies = $('#group-replies > ul.elgg-list, #group-replies > .elgg-list-container > ul.elgg-list');
	if (ul_replies)
	{
		var ul = ul_replies;
		var function_to_call = 'galliComments/reply';
		var obj_type = elgg.echo('replies');
		var item_type = 'discussion_reply';
	}
	else
	{
		var ul = ul_comments;
		var function_to_call = 'galliComments/add';
		var obj_type = elgg.echo('comments');
		var item_type = 'comment';
	}
	elgg.action(function_to_call, {
		data: data,
		success: function(json) {
			if(!riverId){
				// allow plugins to prepend comment when annotations are ordered by 'time_created desc' || Or perform own action
				// Thanks to Manutopik(https://github.com/ManUtopiK) for the hook
				var orderBy = elgg.trigger_hook('getOptions', 'elgg.galliComments.submit', json.output, 'asc');
				if (orderBy ==  'asc') {
					if (ul.length < 1) {
						form.parent().append('<h3 id="' + obj_type + '">' + obj_type + '</h3><ul class="elgg-list elgg-list-entity"><li class="elgg-item elgg-item-object elgg-item-object-' + item_type + '">' + json.output + '</li></ul>');
					} else {
						ul.append($('<li class="elgg-item elgg-item-object elgg-item-object-' + item_type + '">' + json.output + '</li>'));
					}
				} else if (orderBy == 'desc') {
					if (ul.length < 1) {
						form.parent().append(json.output);
					} else {
						ul.prepend($(json.output));
					}
				} // else if other than 'asc' or 'desc' lets plugin perform own action
				if (is_tinymce_active) {
					tinymce.activeEditor.setContent('');
				} else {
					form.find('textarea').val('');
				}
			} else {
				var riverLi = $("#item-river-" + riverId);
				$.ajax({type: "GET",
					url: '<?php echo elgg_get_site_url()."ajax/view/galliComments/singleriver?id=";?>' + riverId,
					dataType: "html",
					cache: false,
					success: function(htmlData) {
						if (htmlData.length > 0) {
							riverLi.empty();
							riverLi.html($(htmlData));
						}
					}
				});
			}
		}
	});
};
elgg.register_hook_handler('init', 'system', elgg.galliComments.init);
