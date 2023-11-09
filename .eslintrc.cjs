module.exports = {
    extends: [
        'eslint:recommended',
        'plugin:vue/vue3-recommended',
        'prettier'
    ],
    // parserに'vue-eslint-parser'を指定し、'@typescript-eslint/parser'はparserOptionsに指定する
    parser: 'vue-eslint-parser',
    parserOptions: {
        parser: '@typescript-eslint/parser',
    },
    rules: {
        // override/add rules settings here, such as:

        // ignorePatternに合致する未使用変数があってもエラーにしない
        "vue/no-unused-vars": ["error", {
            "ignorePattern": "^_"
        }],
        'vue/require-default-prop': 'off',
        'vue/multi-word-component-names': 'off'
    },
}
