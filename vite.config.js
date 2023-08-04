import { defineConfig } from "vite";
import { fileURLToPath } from "url";
import path from "path";

export default defineConfig({
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