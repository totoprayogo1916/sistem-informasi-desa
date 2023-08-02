import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { viteStaticCopy } from "vite-plugin-static-copy";
import path from 'path';

export default defineConfig({
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            '~simplebar': path.resolve(__dirname, 'node_modules/simplebar'),
        }
    },
    plugins: [
        laravel({
            input: [
                "resources/scss/app.scss",
                "resources/js/app.js",
            ],
            refresh: true,
        }),

        // viteStaticCopy({
        //     targets: [
        //         { src: "node_modules/font-awesome/css/font-awesome.min.css", dest: "vendors/fontawesome/css" },
        //         { src: "node_modules/font-awesome/fonts", dest: "vendors/fontawesome" },

        //         { src: "node_modules/jquery-colorbox/jquery.colorbox-min.js", dest: "vendors" },
        //         { src: "node_modules/jquery/jquery.min.*", dest: "vendors" },

        //         { src: './node_modules/tinymce/*', dest: "vendors/tinymce" },
        //     ],
        // }),
    ],
});
