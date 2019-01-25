<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Example Component <spinner></spinner></div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
    <quill-editor v-model="content"
                  ref="quillEditorA"
                  :options="editorOption"
                  @blur="onEditorBlur($event)"
                  @focus="onEditorFocus($event)"
                  @ready="onEditorReady($event)"
                  class="h-24">
		</quill-editor>
    <div class="content ql-editor" v-html="content"></div>
  </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
      message: 'Hi from Vue.',
      content: '<h2>I am Example A</h2>',
      editorOption: {
        placeholder: 'Whats in your mind',
        theme: 'snow',
        modules: {
          ImageResize: {
            modules: [ 'Resize', 'DisplaySize', 'Toolbar' ]
          },
          toolbar: [
            [{ 'font': [] }],
            [{ 'size': ['small', false, 'large', 'huge'] }],
            ['bold', 'italic', 'underline', 'strike'], 
            [{ 'color': [] }, { 'background': [] }],
            [{ 'align': [] }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'script': 'sub'}, { 'script': 'super' }],
            [{ 'indent': '-1'}, { 'indent': '+1' }],

            ['blockquote'],

            ['link', 'image'],

            ['clean']
          ]
        }
      }
    }
  },
  methods: {
    onEditorBlur(quill) {
      console.log('editor blur!', quill)
    },
    onEditorFocus(quill) {
      console.log('editor focus!', quill)
    },
    onEditorReady(quill) {
      console.log('editor ready!', quill)
    }
  },
  computed: {
    editorA() {
      return this.$refs.quillEditorA.quill
    }
  },
  mounted() {
    console.log('this is quill A instance object', this.editorA)
  }


}
</script>
