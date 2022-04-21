

function LoadCompetitions({competitions}){
    
    return(
        <div className="companyCompetitions">

            {competitions.map(({companyId, company ,formUrl}, u) => ( //maps out competitions that are from other companies
                <div key={u}>
                        
                        <a href={formUrl} className="competitionLink">{company.name}</a>
                    <br/>
                </div>
            ))}

        </div>
    )
   

}

export default LoadCompetitions;