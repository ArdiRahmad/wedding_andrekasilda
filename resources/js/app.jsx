import React, { useEffect } from "react";
import { createRoot } from "react-dom/client";
import { createInertiaApp } from "@inertiajs/react";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";

createInertiaApp({
    // Below you can see that we are going to get all React components from resources/js/Pages folder
    progress: {
        delay: 250,

        // The color of the progress bar.
        color: "#152F60",

        // Whether to include the default NProgress styles.
        includeCSS: true,

        // Whether the NProgress spinner will be shown.
        showSpinner: false,
        progress: true,
    },
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.jsx`,
            import.meta.glob("./Pages/**/*.jsx")
        ),
    setup({ el, App, props }) {
        const RootComponent = () => {
            return <App {...props} />;
        };
        createRoot(el).render(<RootComponent />);
    },
});
