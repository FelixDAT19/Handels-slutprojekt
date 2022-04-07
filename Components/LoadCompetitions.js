import Link from "next/link";

function LoadCompetitions({competitions}){
    
    return(
        <div id="Competitions">

            {competitions.map(({companyId, company ,formUrl}, u) => ( //maps out sponsors
                <div key={u}>
                        <p id={companyId}>{company.name}</p>
                        <Link passHref={formUrl}>{formUrl}</Link>
                    <br/>
                </div>
            ))}

        </div>
    )
   

}

export default LoadCompetitions;