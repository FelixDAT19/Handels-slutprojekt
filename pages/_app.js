import'/styles/slut.css';
import'/styles/map.css';
import'/styles/listDropdown.css';
import'/styles/offer.css';
import'/styles/company.css';
import'/styles/competitions.css';
import { useEffect } from 'react'; //import of css and useeffect

export default function MyApp({ Component, pageProps }) {

    useEffect(() => { //settings for service worker
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