
function LoadFood({offers}){ //loads offers from companies that offer food

    

    return offers.map(({ name, foodCheck, offers }, p) => { //maps out company name
        if (foodCheck === true && offers != "") { // checks if a campany is a food company or not and if it is it displays only food comany offers
            return (
                <div key={p} className="companyOffer">
                    <h3 className="companyOfferName">{name}</h3>
                    
                    {offers.map(({ offer, price}, f) => ( //puts the offer information under company name
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