
function LoadOffers({offers}){ //loads offers from companies that dont offer food

    

    return offers.map(({ company, offer, price }, p) => {
        if (company.foodCheck === false) {
            return (
                <div key={p}>
                    <h3>{company.name}</h3>
                    <p className="btn">{offer} {price}</p>
                </div>
            );
        } 
    });
    

}
export default LoadOffers;