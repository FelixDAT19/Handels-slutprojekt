import Sponsors from "./Sponsors";

function FooterMenu({sponsors}){ //footer page with sponsors

    return(
        <>
            <Sponsors sponsors={sponsors}/> {/* show sponsors above footer */}
            
            <div className="footer">

                <p id="footerText">
                    Sidan är skapad av grupp 2
                </p>

            </div>
        </>
    )
}

export default FooterMenu;