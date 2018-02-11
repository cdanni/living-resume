(function() {
	'use strict';

	/* Register the buttons */
	tinymce.create('tinymce.plugins.LRButtons', {
		init : function(editor, url) {

			editor.addButton('lr-display-resume', {
				title : 'Add Living Resume',
				icon: 'fa-briefcase',
				classes: 'lr-resume', 
				onclick: function () {
					editor.windowManager.open({
						title: 'Add Living Resume',
						width: 500,
						height: 200,
						body: [{
							type: 'listbox',
							name: 'ResumeList',
							label: 'Select Resume',
							values: editor.settings.ResumeList 
						}],

						onsubmit: function (e) {
							// Insert content when the window form is submitted
							editor.insertContent('[livingresume-resume resume_id="' + e.data.ResumeList + '"]');
						},

					});
				}
			});

			editor.addButton('lr-display-endorsement-form', {
				title : 'Add Endorsement Form',
				icon: 'fa-file-text',
				classes: 'lr-endorse', 
				onclick: function () {
					editor.insertContent('[livingresume-endorsement-form]');
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		},
	});
	/* Start the buttons */
	tinymce.PluginManager.add( 'living-resume-buttons', tinymce.plugins.LRButtons );
})();
