//<script>
elgg.provide('elgg.galliComments');

elgg.galliComments.init = function() {
	$('.elgg-form-comment-save').find('input[type=submit]').on('click', elgg.galliComments.submit);
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
	elgg.action('galliComments/add', {
		data: data,
		success: function(json) {
			if(!riverId){
				var ul = $('.elgg-comments > ul.elgg-list, .elgg-comments > .elgg-list-container > ul.elgg-list');
				// allow plugins to prepend comment when annotations are ordered by 'time_created desc' || Or perform own action
				// Thanks to Manutopik(https://github.com/ManUtopiK) for the hook
				var orderBy = elgg.trigger_hook('getOptions', 'elgg.galliComments.submit', json.output, 'asc');
				if (orderBy ==  'asc') {
					if (ul.length < 1) {
						form.parent().append('<h3 id="comments">comments</h3><ul class="elgg-list elgg-list-entity"><li class="elgg-item elgg-item-object elgg-item-object-comment">' + json.output + '</li></ul>');
					} else {
						ul.append($('<li class="elgg-item elgg-item-object elgg-item-object-comment">' + json.output + '</li>'));
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
