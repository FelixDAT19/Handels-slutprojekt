
function LoadOffers({offers}){ //loads offers from companies that dont offer food

    

    return offers.map(({ name, foodCheck, offers }, p) => { //used to map out the names
        if (foodCheck === false && offers != "") { // check if the company is not a food company and if not it displays the company and offers
            return (
                <div key={p} className="companyOffer">
                    <h3 className="companyOfferName">{name}</h3>
                    
                    {offers.map(({ offer, price}, f) => ( // displays the company offers under specific company
                        <div key={f} className="offerInformation">
                            <div className="offerName">{offer}</div>
                            <div className="offerPrice">{price+" €"}</div>
                        </div>
                    ))}
                </div>
            );
        } 
    });
    

}
export default LoadOffers;