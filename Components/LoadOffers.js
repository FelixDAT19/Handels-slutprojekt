
function LoadOffers({offers}){

    

    return offers.map(({ company, offer, price }, p) => {
        if (company.foodCheck === false) {
            return (
                <div key={p}>
                    <h3>{company.name}</h3>
                    <p>{offer} {price}</p>
                </div>
            );
        } 
    });
    

}
export default LoadOffers;