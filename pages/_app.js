import'/styles/slut.css';
import'/styles/map.css';
import { useEffect } from 'react';

export default function MyApp({ Component, pageProps }) {

    useEffect(() => {
        if("serviceWorker" in navigator) {
          window.addEventListener("load", function () {
           navigator.serviceWorker.register("/sw.js").then(
              function (registration) {
                console.log("Service Worker registration successful with scope: ", registration.scope);
              },
              function (err) {
                console.log("Service Worker registration failed: ", err);
              }
            );
          });
        }
      }, [])

    return <Component {...pageProps} />
}