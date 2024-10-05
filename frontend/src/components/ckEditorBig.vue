<template>
    <div>
        <div class="main-container">
            <div class="editor-container editor-container_balloon-editor editor-container_include-block-toolbar"
                ref="editorContainerElement">
                <div class="editor-container__editor">
                    <div ref="editorElement">
                        <ckeditor v-if="isLayoutReady" v-model="content" :editor="editor" :config="config" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted, defineComponent, watch, defineEmits } from 'vue';
import * as CKEditor from '@ckeditor/ckeditor5-vue';
import {
    BalloonEditor,
    AccessibilityHelp,
    Autoformat,
    AutoLink,
    Autosave,
    BlockQuote,
    BlockToolbar,
    Bold,
    Code,
    CodeBlock,
    Essentials,
    FindAndReplace,
    Heading,
    Highlight,
    HorizontalLine,
    Indent,
    IndentBlock,
    Italic,
    Link,
    List,
    Paragraph,
    SelectAll,
    SpecialCharacters,
    SpecialCharactersArrows,
    SpecialCharactersCurrency,
    SpecialCharactersEssentials,
    SpecialCharactersLatin,
    SpecialCharactersMathematical,
    SpecialCharactersText,
    Strikethrough,
    Table,
    TableToolbar,
    TextTransformation,
    TodoList,
    Underline,
    Undo
} from 'ckeditor5';

import 'ckeditor5/ckeditor5.css';

export default defineComponent({
    name: 'CkEditorComponent',
    components: {
        CKEditor
    },
    props: {
        editorText: {
            type: String,
            required: true,
            default: ''
        },
        editorIndex: {
            type: Number,
            required: true,
            default: ''
        }
    },
    setup(props, { emit }) {
        const isLayoutReady = ref(false);
        const content = ref(props.editorText);
        const editor = BalloonEditor;

        const config = {
            toolbar: {
                items: [
                    'undo',
                    'redo',
                    '|',
                    'findAndReplace',
                    '|',
                    'heading',
                    '|',
                    'bulletedList',
                    'numberedList',
                    'todoList',
                    '|',
                    'bold',
                    'italic',
                    'underline',
                    'strikethrough',
                    'code',
                    '|',
                    // 'specialCharacters',
                    // 'horizontalLine',
                    'link',
                    'insertTable',
                    'highlight',
                    // 'blockQuote',
                    '|',
                    'outdent',
                    'indent'
                ],
                shouldNotGroupWhenFull: false
            },
            plugins: [
                AccessibilityHelp,
                Autoformat,
                AutoLink,
                Autosave,
                BlockQuote,
                BlockToolbar,
                Bold,
                Code,
                CodeBlock,
                Essentials,
                FindAndReplace,
                Heading,
                Highlight,
                HorizontalLine,
                Indent,
                IndentBlock,
                Italic,
                Link,
                List,
                Paragraph,
                SelectAll,
                SpecialCharacters,
                SpecialCharactersArrows,
                SpecialCharactersCurrency,
                SpecialCharactersEssentials,
                SpecialCharactersLatin,
                SpecialCharactersMathematical,
                SpecialCharactersText,
                Strikethrough,
                Table,
                TableToolbar,
                TextTransformation,
                TodoList,
                Underline,
                Undo
            ],
            blockToolbar: ['bold', 'italic', '|', 'link', 'insertTable', '|', 'outdent', 'indent'],
            heading: {
                options: [
                    {
                        model: 'paragraph',
                        title: 'Paragraph',
                        class: 'ck-heading_paragraph'
                    },
                    {
                        model: 'heading1',
                        view: 'h1',
                        title: 'Heading 1',
                        class: 'ck-heading_heading1'
                    },
                    {
                        model: 'heading2',
                        view: 'h2',
                        title: 'Heading 2',
                        class: 'ck-heading_heading2'
                    },
                    {
                        model: 'heading3',
                        view: 'h3',
                        title: 'Heading 3',
                        class: 'ck-heading_heading3'
                    },
                    {
                        model: 'heading4',
                        view: 'h4',
                        title: 'Heading 4',
                        class: 'ck-heading_heading4'
                    },
                    {
                        model: 'heading5',
                        view: 'h5',
                        title: 'Heading 5',
                        class: 'ck-heading_heading5'
                    },
                    {
                        model: 'heading6',
                        view: 'h6',
                        title: 'Heading 6',
                        class: 'ck-heading_heading6'
                    }
                ]
            },
            placeholder: 'Type or paste your content here!',
            table: {
                contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
            }
        };

        onMounted(() => {
            isLayoutReady.value = true;
        });

        watch(content, () => {
            emit('update:editorText', content, props.editorIndex);
        });

        // const onContentChange = (newContent) => {
        //     content.value = newContent;
        //     emit('update:editorText', newContent);
        // };

        return {
            isLayoutReady,
            content,
            editor,
            config
        };
    }
});
</script>

<style scoped lang="scss">
@import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400;1,700&display=swap');

@media print {
    body {
        margin: 0 !important;
    }
}

/* .ck-content * {
    padding: initial;
    margin: initial;
    border: initial;
    line-height: initial;
    background-color: red !important;
} */

.ck-content ul,
.ck-content ol {
    padding-left: 40px;
    margin: 1rem 0;
    border: initial;
    line-height: initial;
}

.main-container {
    font-family: 'Lato';
    width: fit-content;
    margin-left: auto;
    margin-right: auto;
}

.ck-content {
    font-family: 'Lato';
    line-height: 1.6;
    word-break: break-word;
}

.editor-container_include-block-toolbar {
    margin-left: 42px;
}

.editor-container_balloon-editor .editor-container__editor {
    min-width: 795px;
    max-width: 795px;
}
</style>
