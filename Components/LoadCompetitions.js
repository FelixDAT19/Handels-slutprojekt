import company from "../pages/company/[id]";

function LoadCompetitions({competitions}){
    
    return(
        <div id="Competitions">

            {competitions.map(({companyId, company ,formUrl}, u) => ( //maps out sponsors
                <div key={u}>
                        <p id={companyId}>{company.name}</p>
                        <a passHref={formUrl}>{formUrl}</a>
                    <br/>
                </div>
            ))}

        </div>
    )
   

}

export default LoadCompetitions;