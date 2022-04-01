import Link from "next/link";
import Sponsors from "./Sponsors";

function FooterMenu({sponsors}){

    return(
        <>
            <Sponsors sponsors={sponsors}/> {/* show sponsors above footer */}
            
            <div id="footer">

                <p id="footerText">
                    Sidan är skapad av Felix
                </p>

            </div>
        </>
    )
}

export default FooterMenu;