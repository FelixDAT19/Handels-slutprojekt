import Sponsors from "./Sponsors";

function FooterMenu({sponsors}){ //footer page with sponsors

    return(
        <>
            <Sponsors sponsors={sponsors}/> {/* show sponsors above footer */}
            
            <div className="footer">

                <p id="footerText">
                    placeholder@email.ax
                    <br/>
                    <a href="https://www.datanom.ax/~viktork/Handelsmassan/">Handelsmassan</a>
                </p>

            </div>
        </>
    )
}

export default FooterMenu;