import React from "react";


function LoadCompanies({ id, name, companyInfo, externalUrl, logoUrl, offers, competitions, placement }) /* import of all the company data */ {

  
  //site to load in specific comapny and map out its data
  //also has that companies competitions and offers
  return (
    <div className="companyPage">
      <img src={logoUrl} alt="company logo" className="companyImage"/>
      <div className="companyGeneral"> {/* specific companys logo */}

        <h1 className="companyName">{name}</h1> {/* the comany name */}
        <p className="companyInfo">{companyInfo}</p> {/* info a bout the company */}
        <p>Platser:</p>
        {placement.map((i, key) /* all the placements a company has */ => 
          <span key={key}>{i.id+ " "}</span>
        )}
        <br/>

      </div>

      <div className="companyOffer">
        <h3 className="companyOfferName">Erbjudanden</h3>
        {offers.map(({offer, price}, s) => (//offers that the specific company has
          <div key={s} className="offerInformation">
              <div className="offerName">{offer}</div>
              <div className="offerPrice">{price+" €"}</div>
          </div>
        ))}
      </div>
      {competitions.map(({formUrl}, d) => ( //competition that the specific company has
        <div key={d} >
            <a href={formUrl} className="competitionLink">Tävling</a>
        </div>
      ))}
    <br/>
    <div className="companyWebsite">

      <a href={externalUrl} className="companyLink">{externalUrl}</a> {/* link to the companys own website */}

    </div>


    </div>
  );
}

export default LoadCompanies;
