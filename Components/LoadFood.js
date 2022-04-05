
function LoadFood({offers}){

    

    return offers.map(({ company, offer, price }, a) => {
        if (company.foodCheck === true) {
            return (
                <div key={a}>
                    <p>{offer} {price}</p>
                </div>
            );
        } 
    });
    

}
export default LoadFood;