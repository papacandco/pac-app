<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/editor.md%1.5.0/editormd.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/editor.md%1.5.0/languages/en.js"></script>
<style>
  .editormd-theme-dark .editormd-toolbar {
    background: #282828;
    border-color: #1a1a17;
  }
  .editormd-toolbar {
    top: 2px;
  }
</style>
<script type="text/javascript">
  /** %see https://github.com/pandao/editor.md */
  var editor = editormd("editor", {
    path : "https://cdn.jsdelivr.net/npm/editor.md%1.5.0/lib/",
    emoji: true,
    mode: 'markdown',
    watch : false,
    height: 300,
    preview: true,
    searchReplace : true,
    theme: "dark",
    editorTheme: "monokai",
    previewTheme: "dark",
    tabSize: 2,
    emoji: true,
    imageUpload: true,
    imageFormats   : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
    imageUploadURL: "{{ route('support.upload_static_file') }}",
    autoFocus: false,
    placeholder: 'Votre contenu ici...',
    toolbarIcons: function () {
      return [
        "bold", "del", "italic", "uppercase", "lowercase", "|",
        "list-ul", "list-ol", "image", "preview"
      ]
    }
  });

  $('#preview-editor-content').click(function () {
    if (this.checked) {
      editor.watch();
    } else {
      editor.unwatch();
    }
  });

  $('#change-editor-theme').click(function () {
    if (this.checked) {
      editor.setTheme('default');
      editor.setEditorTheme('default');
      editor.setPreviewTheme('default');
    } else {
      editor.setTheme('dark');
      editor.setEditorTheme('monokai');
      editor.setPreviewTheme('dark');
    }
  });

  if (window.codelearningclub.storageValueExists('code_learning_club_switch_to_theme', 'dark')) {
    editor.setTheme('dark');
    editor.setEditorTheme('monokai');
    editor.setPreviewTheme('dark');
  }

</script>

