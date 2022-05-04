
function LoadFood({offers}){ //loads offers from companies that offer food

    

    return offers.map(({ name, foodCheck, offers }, p) => {
        if (foodCheck === true && offers != "") {
            return (
                <div key={p} className="companyOffer">
                    <h3 className="companyOfferName">{name}</h3>
                    
                    {offers.map(({ offer, price}, f) => (
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
export default LoadFood;