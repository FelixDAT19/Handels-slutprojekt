

function LoadCompetitions({competitions}){
    
    return(
        <div className="competitionCompetitions">
        <nav className="companyDropdownNav">
            <label htmlFor="btn" className="first dropdownButton">Företags Tävlingar
            <span className="fas fa-caret-down"></span>
            </label>
            <input type="checkbox" id="btn" className="dropdownCheckbox"/>
            <ul className="menuCompany firstUl">

            {competitions.map(({company ,formUrl}, u) => ( 
                <li key={u} className="listItems firstLI"><a href={formUrl} className="competitionLink">{company.name}</a></li>
            ))}    
        
            </ul>
     </nav>
     </div>

    )
   

}

export default LoadCompetitions;

/*

        <div className="companyCompetitions">

            {competitions.map(({companyId, company ,formUrl}, u) => ( //maps out competitions that are from other companies
                <div key={u}>
                        
                        <a href={formUrl} className="competitionLink">{company.name}</a>
                    <br/>
                </div>
            ))}

        </div>

*/