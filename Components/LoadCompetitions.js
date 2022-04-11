

function LoadCompetitions({competitions}){
    
    return(
        <div id="Competitions">

            {competitions.map(({companyId, company ,formUrl}, u) => ( //maps out competitions that ar from other companies
                <div key={u}>
                        <p id={companyId}>{company.name}</p>
                        <a href={formUrl}>{formUrl}</a>
                    <br/>
                </div>
            ))}

        </div>
    )
   

}

export default LoadCompetitions;