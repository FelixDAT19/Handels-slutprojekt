
function LoadOffers({offers}){

    

    return offers.map(({ company, offer, price }, p) => {
        if (company.foodCheck === false) {
            return (
                <div key={p}>
                    <p>{offer} {price}</p>
                </div>
            );
        } else if (company.foodCheck === true) {
            return (
                <div key={p}>
                    <p>{offer} {price}</p>
                </div>
            );
        } 
    });
    

}
export default LoadOffers;