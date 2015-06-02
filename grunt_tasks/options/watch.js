module.exports = {
    css: {
        files: ['web/bundles/*/less/*.less'],
        tasks: ['css', 'command:assetic_dump']
    },
    javascript: {
        files: ['web/bundles/*/coffee/*.coffee'],
        tasks: ['javascript', 'command:assetic_dump']
    }
};
