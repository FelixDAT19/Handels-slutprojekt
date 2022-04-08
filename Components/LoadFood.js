
function LoadFood({offers}){ //loads offers from companies that offer food

    

    return offers.map(({ company, offer, price }, a) => {
        if (company.foodCheck === true) {
            return (
                <div key={a}>
                    <h3>{company.name}</h3>
                    <p className="btn">{offer} {price}</p>
                </div>
            );
        } 
    });
    

}
export default LoadFood;