

function LoadCompetitions({competitions}){
    
    return(
        <div className="companyCompetitions">

            {competitions.map(({companyId, company ,formUrl}, u) => ( //maps out competitions that ar from other companies
                <div key={u}>
                        <p className="companyName">{company.name}</p>
                        <a href={formUrl} className="competitionLink">{formUrl}</a>
                    <br/>
                </div>
            ))}

        </div>
    )
   

}

export default LoadCompetitions;