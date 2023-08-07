import { defineConfig } from "vite";
import { fileURLToPath } from "url";
import path from "path";
import prismjs from "vite-plugin-prismjs";

export default defineConfig({
    plugins: [
        prismjs({
            languages: ["java", "javascript", "css", "php", "markup", "sql", "c", "c#", "yaml", "json"],
            plugins: ["line-numbers", "show-language", "copy-to-clipboard"],
            theme: "default",
            css: true,
        }),
    ],
    build: {
        outDir: fileURLToPath(new URL("./dist", import.meta.url)),
        lib: {
            entry: path.resolve(__dirname, 'lib/main.js'),
            name: 'icefox',
            fileName: 'icefox',
            formats: ["iife"]
        }
    }
})