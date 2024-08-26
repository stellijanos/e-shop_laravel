import modulesConfig from "./modulesConfig";

export const imports = async (currentPath) => {
    await importModules(modulesConfig["*"]);

    for (let path in modulesConfig) {
        if (path === "*") continue;
        const regex = new RegExp(`^${path}$`);
        if (regex.test(currentPath)) {
            await importModules(modulesConfig[path]);
        }
    }
};

async function importModules(modules) {
    modules.forEach(module => {
        import(module.module).then((m) => {
            if (module.functions) {
                module.functions.forEach(callback => m[callback]())
            }
        });
    })
}
